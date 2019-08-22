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
        Portions created by the Initial Developer are Copyright (C) 2008-2017
        the Initial Developer. All Rights Reserved.

        Contributor(s):
        Mark J Crane <markjcrane@fusionpbx.com>
*/

//includes
        include "root.php";
        require_once "resources/require.php";
        require_once "resources/check_auth.php";

//check permissions
        if (permission_exists('site_view')) {
                //access granted
        }
        else {
                echo "access denied";
                exit;
        }
//add multi-lingual support
        $language = new text;
        $text = $language->get();

//additional includes
        require_once "resources/header.php";
        require_once "resources/paging.php";

//get variables used to control the order
        $order_by = $_GET["order_by"];
        $order = $_GET["order"];

//show the content
        echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>\n";
        echo "  <tr>\n";
        echo "          <td width='50%' align='left' nowrap='nowrap'><b>".$text['title-sites']."</b></td>\n";
        echo "          <td width='50%' align='right'>&nbsp;</td>\n";
        echo "  </tr>\n";
        echo "  <tr>\n";
        echo "          <td align='left' colspan='2'>\n";
        echo "                  ".$text['description-sites']."<br /><br />\n";
        echo "          </td>\n";
        echo "  </tr>\n";
        echo "</table>\n";

//prepare to page the results
        $sql = "select count(*) as num_rows from v_sites";
        if (strlen($order_by)> 0) { $sql .= "order by $order_by $order "; }
        $prep_statement = $db->prepare($sql);
        if ($prep_statement) {
        $prep_statement->execute();
                $row = $prep_statement->fetch(PDO::FETCH_ASSOC);
                if ($row['num_rows'] > 0) {
                        $num_rows = $row['num_rows'];
                }
                else {
                        $num_rows = '0';
                }
        }

//prepare to page the results
        $rows_per_page = ($_SESSION['domain']['paging']['numeric'] != '') ? $_SESSION['domain']['paging']['numeric'] : 50;
        $param = "";
        $page = $_GET['page'];
        if (strlen($page) == 0) { $page = 0; $_GET['page'] = 0; }
        list($paging_controls, $rows_per_page, $var3) = paging($num_rows, $param, $rows_per_page);
        $offset = $rows_per_page * $page;

//get the  list
        $sql = "select * from v_sites ";
        if (strlen($order_by)> 0) { $sql .= "order by $order_by $order "; } else { $sql .= "order by sitename asc "; }
        $sql .= " limit $rows_per_page offset $offset ";
        $prep_statement = $db->prepare(check_sql($sql));
        $prep_statement->execute();
        $result = $prep_statement->fetchAll();
        $result_count = count($result);
        unset ($prep_statement, $sql);

//table headers
        $c = 0;
        $row_style["0"] = "row_style0";
        $row_style["1"] = "row_style1";
        echo "<table class='tr_hover' width='100%' border='0' cellpadding='0' cellspacing='0'>\n";
        echo "<tr>\n";
        echo th_order_by('sitename', $text['label-name'], $order_by, $order);
        echo th_order_by('operator', $text['label-operator'], $order_by, $order);
        echo th_order_by('site_uuid', 'site_uuid', $order_by, $order);
        echo "<td class='list_control_icons'>";
        if (permission_exists('site_add')) {
                echo "<a href='sites_edit.php' alt='".$text['button-add']."'>$v_link_label_add</a>";
        }
        echo "</td>\n";
        echo "</tr>\n";

//show the results
        if ($result_count > 0 ) {
                foreach($result as $row) {
			if ($row['site_uuid'] != 'b48409dc-2fae-4e4e-9dba-05009b6ff40a'){
                        // $tr_link = (permission_exists('site_edit')) ? "href='sites_edit.php?id=".$row['site_uuid']."'" : null;
                        echo "<tr ".$tr_link.">\n";
                        echo "  <td valign='top' class='".$row_style[$c]."'>";
                        if (permission_exists('site_edit')) {
                                echo "<a href='sites_edit.php?id=".$row['site_uuid']."'>".$row['sitename']."</a>";
                        }
                        else {
                                echo $row['sitename'];
                        }
                        echo "  </td>\n";

                        echo "  <td valign='top' class='".$row_style[$c]."'>";
                        if (permission_exists('site_edit')) {
                                echo "<a href='sites_edit.php?id=".$row['site_uuid']."'>".$row['operator']."</a>";
                        }
                        else {
                                echo $row['operator'];
                        }
                        echo "  </td>\n";
						echo "  <td valign='top' class='".$row_style[$c]."'>";
                        if (permission_exists('site_edit')) {
                                echo $row['site_uuid'];
                        }
                        else {
                                echo $row['site_uuid'];
                        }
                        echo "  </td>\n";
                        echo "  <td class='list_control_icons'>";
                        if (permission_exists('site_edit')) {
                                echo "<a href='sites_edit.php?id=".$row['site_uuid']."' alt='".$text['button-edit']."'>$v_link_label_edit</a>";
                        }
                        if (permission_exists('site_delete')) {
                                echo "<a href='sites_delete.php?id=".$row['site_uuid']."' alt='".$text['button-delete']."' onclick=\"return confirm('".$text['confirm-delete']."')\">$v_link_label_delete</a>";
                        };
                        echo "  </td>";
                        echo "</tr>\n";
                        if ($c==0) { $c=1; } else { $c=0; }
			}
                } //end foreach
                unset($sql, $result, $row_count);
        } //end if results

//complete the content
        echo "<tr>\n";
        echo "<td colspan='11' align='left'>\n";
        echo "  <table width='100%' cellpadding='0' cellspacing='0'>\n";
        echo "  <tr>\n";
        echo "          <td width='33.3%' nowrap>&nbsp;</td>\n";
        echo "          <td width='33.3%' align='center' nowrap>$paging_controls</td>\n";
        echo "          <td class='list_control_icons'>";
        if (permission_exists('call_block_add')) {
                echo "<a href='sites_edit.php' alt='".$text['button-add']."'>$v_link_label_add</a>";
        }
        echo "          </td>\n";
        echo "  </tr>\n";
        echo "  </table>\n";
        echo "</td>\n";
        echo "</tr>\n";

        echo "</table>";
        echo "<br /><br />";

//include the footer
        require_once "resources/footer.php";

?>
