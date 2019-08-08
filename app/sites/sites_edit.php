<?php
/*
	FusionPBX
	Version: MPL 1.1

	The contents of this file are subject to the Mozilla Public License Version
	1.1 (the "License"); you may not use this file except in compliance with
	the License. You may obtain a copy of the License at
	http://www.mozilla.org/MPL/

	Software distributed under the License is distributed on an "AS IS" basis,
	WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License
	for the specific language governing rights and limitations under the
	License.

	The Original Code is FusionPBX

	The Initial Developer of the Original Code is
	Mark J Crane <markjcrane@fusionpbx.com>
	Portions created by the Initial Developer are Copyright (C) 2008-2015
	the Initial Developer. All Rights Reserved.

	Contributor(s):
	Mark J Crane <markjcrane@fusionpbx.com>
	Luis Daniel Lucio Quiroz <dlucio@okay.com.mx>

*/
require_once "root.php";
require_once "resources/require.php";
require_once "resources/check_auth.php";

if (permission_exists('site_edit') || permission_exists('site_add')) {
	//access granted
}
else {
	echo "access denied";
	exit;
}

//add multi-lingual support
	$language = new text;
	$text = $language->get();

//action add or update
	if (isset($_REQUEST["id"])) {
		$action = "update";
		$site_uuid = check_str($_REQUEST["id"]);
	}
	else {
		$action = "add";
	}

//get http post variables and set them to php variables
	if (count($_POST) > 0) {
		$sitename = check_str($_POST["sitename"]);
                $operator = check_str($_POST["operator"]);
	}

if (count($_POST)>0 && strlen($_POST["persistformvar"]) == 0) {

	$msg = '';
	if ($action == "update") {
		$site_uuid = check_str($_POST["site_uuid"]);
	}

	//check for all required data
		if ($action == "add") {
			if (strlen($sitename) == 0) { $msg .= $text['label-provide-number']."<br>\n"; }
		}
		if (strlen($msg) > 0 && strlen($_POST["persistformvar"]) == 0) {
			require_once "resources/header.php";
			require_once "resources/persist_form_var.php";
			echo "<div align='center'>\n";
			echo "<table><tr><td>\n";
			echo $msg."<br />";
			echo "</td></tr></table>\n";
			persistformvar($_POST);
			echo "</div>\n";
			require_once "resources/footer.php";
			return;
		}

	//add or update the database
		if (($_POST["persistformvar"] != "true")>0) {
                        if ($action == "add") {
				$sql = "insert into v_sites ";
				$sql .= "(";
				$sql .= "site_uuid, ";
                                $sql .= "operator, ";
				$sql .= "sitename";
				$sql .= ") ";
				$sql .= "values ";
				$sql .= "(";
				$sql .= "'".uuid()."', ";
                                $sql .= "'$operator', ";
				$sql .= "'$sitename'";
				$sql .= ")";
				$db->exec(check_sql($sql));
				unset($sql);

				messages::add($text['label-add-complete']);
				header("Location: sites.php");
				return;
			} //if ($action == "add")

			if ($action == "update") {
				$sql = " select sitename,operator from v_sites ";
				$sql .= "where site_uuid = '$site_uuid'";

				$prep_statement = $db->prepare(check_sql($sql));
				$prep_statement->execute();
				$result = $prep_statement->fetchAll();
				$result_count = count($result);
				unset ($prep_statement, $sql);

				$sql = "update v_sites set ";
				$sql .= "sitename = '$sitename',operator='$operator' ";
				$sql .= "where site_uuid = '$site_uuid'";
				$db->exec(check_sql($sql));
				unset($sql);

				messages::add($text['label-update-complete']);
				header("Location: sites.php");
				return;
			} //if ($action == "update")
		} //if ($_POST["persistformvar"] != "true")
} //(count($_POST)>0 && strlen($_POST["persistformvar"]) == 0)

//pre-populate the form
	if (count($_GET)>0 && $_POST["persistformvar"] != "true") {
		$site_uuid = $_GET["id"];
		$sql = "select * from v_sites ";
		$sql .= "where site_uuid = '$site_uuid' ";
		$prep_statement = $db->prepare(check_sql($sql));
		$prep_statement->execute();
		$result = $prep_statement->fetchAll();
		foreach ($result as &$row) {
			$sitename = $row["sitename"];
                        $operator = $row["operator"];
			break; //limit to 1 row
		}
		unset ($prep_statement, $sql);
	}

//show the header
	require_once "resources/header.php";

//show the content
	echo "<form method='post' name='frm' action=''>\n";
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>\n";
	echo "<tr>\n";
	if ($action == "add") {
		echo "<td align='left' width='30%' nowrap='nowrap'><b>".$text['label-edit-add']."</b></td>\n";
	}
	if ($action == "update") {
		echo "<td align='left' width='30%' nowrap='nowrap'><b>".$text['label-edit-edit']."</b></td>\n";
	}
	echo "<td width='70%' align='right'>";
	echo "	<input type='button' class='btn' name='' alt='".$text['button-back']."' onclick=\"window.location='sites.php'\" value='".$text['button-back']."'>";
	echo "	<input type='submit' name='submit' class='btn' value='".$text['button-save']."'>\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td align='left' colspan='2'>\n";
	if ($action == "add") {
	echo $text['label-add-note']."<br /><br />\n";
	}
	if ($action == "update") {
	echo $text['label-edit-note']."<br /><br />\n";
	}
	echo "</td>\n";
	echo "</tr>\n";
	if ($site_uuid != 'b48409dc-2fae-4e4e-9dba-05009b6ff40a') {
	echo "<tr>\n";
	echo "<td class='vncellreq' valign='top' align='left' nowrap='nowrap'>\n";
	echo "	".$text['label-name']."\n";
	echo "</td>\n";
	echo "<td class='vtable' align='left'>\n";
	echo "	<input class='formfld' type='text' name='sitename' maxlength='255' value=\"$sitename\" required='required'>\n";
	echo "<br />\n";
	echo $text['description-name']."\n";
	echo "</td>\n";
	echo "</tr>\n";
        echo "<tr>\n";
        echo "<td class='vncellreq' valign='top' align='left' nowrap='nowrap'>\n";
        echo "  ".$text['label-operator']."\n";
        echo "</td>\n";
        echo "<td class='vtable' align='left'>\n";
        echo "  <input class='formfld' type='text' name='operator' maxlength='255' value=\"$operator\" required='required'>\n";
        echo "<br />\n";
        echo $text['description-operator']."\n";
        echo "</td>\n";
        echo "</tr>\n";


	}

	echo "	<tr>\n";
	echo "		<td colspan='2' align='right'>\n";
	if ($action == "update") {
		echo "		<input type='hidden' name='site_uuid' value='$site_uuid'>\n";
	}
	echo "			<br>";
	echo "			<input type='submit' name='submit' class='btn' value='".$text['button-save']."'>\n";
	echo "		</td>\n";
	echo "	</tr>";
	echo "</table>";
	echo "<br><br>";
	echo "</form>";


//include the footer
	require_once "resources/footer.php";
?>
