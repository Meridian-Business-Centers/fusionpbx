<?php

	//application details
		$apps[$x]['name'] = "Sites";
		$apps[$x]['uuid'] = "df27505f-d502-4cf7-80ef-54e135f85651";
		$apps[$x]['category'] = "Switch";
		$apps[$x]['subcategory'] = "";
		$apps[$x]['version'] = "";
		$apps[$x]['license'] = "Mozilla Public License 1.1";
		$apps[$x]['url'] = "http://www.fusionpbx.com";
		$apps[$x]['description']['en-us'] = "A tool to to add sites to extensions.";
		$apps[$x]['description']['es-cl'] = "A tool to to add sites to extensions.";
		$apps[$x]['description']['de-de'] = "";
		$apps[$x]['description']['de-ch'] = "";
		$apps[$x]['description']['de-at'] = "";
		$apps[$x]['description']['fr-fr'] = "A tool to to add sites to extensions.";
		$apps[$x]['description']['fr-ca'] = "";
		$apps[$x]['description']['fr-ch'] = "";
		$apps[$x]['description']['pt-pt'] = "A tool to to add sites to extensions.";
		$apps[$x]['description']['pt-br'] = "A tool to to add sites to extensions.";

	//permission details
		$y = 0;
		$apps[$x]['permissions'][$y]['name'] = "site_view";
		$apps[$x]['permissions'][$y]['menu']['uuid'] = "cc29adfc-f288-4c36-a968-be5fc864fc7b";
		$apps[$x]['permissions'][$y]['groups'][] = "superadmin";
		$apps[$x]['permissions'][$y]['groups'][] = "admin";
		$y++;
		$apps[$x]['permissions'][$y]['name'] = "site_add";
		$apps[$x]['permissions'][$y]['groups'][] = "superadmin";
		$apps[$x]['permissions'][$y]['groups'][] = "admin";
		$y++;
		$apps[$x]['permissions'][$y]['name'] = "site_edit";
		$apps[$x]['permissions'][$y]['groups'][] = "superadmin";
		$apps[$x]['permissions'][$y]['groups'][] = "admin";
		$y++;
		$apps[$x]['permissions'][$y]['name'] = "site_delete";
		$apps[$x]['permissions'][$y]['groups'][] = "superadmin";
		$apps[$x]['permissions'][$y]['groups'][] = "admin";
                $y++;

	//schema details
                $y = 1; //table array index
                $z = 0; //field array index
                $apps[$x]['db'][$y]['table']['name'] = "v_sites";
                $apps[$x]['db'][$y]['table']['parent'] = "";
                $z=0;
                $apps[$x]['db'][$y]['fields'][$z]['name'] = "site_uuid";
                $apps[$x]['db'][$y]['fields'][$z]['type']['pgsql'] = "uuid";
                $apps[$x]['db'][$y]['fields'][$z]['type']['sqlite'] = "text";
                $apps[$x]['db'][$y]['fields'][$z]['type']['mysql'] = "char(36)";
                $apps[$x]['db'][$y]['fields'][$z]['key']['type'] = "primary";
                $z++;
                $apps[$x]['db'][$y]['fields'][$z]['name'] = "operator_uuid";
                $apps[$x]['db'][$y]['fields'][$z]['type']['pgsql'] = "uuid";
                $apps[$x]['db'][$y]['fields'][$z]['type']['sqlite'] = "text";
                $apps[$x]['db'][$y]['fields'][$z]['type']['mysql'] = "char(36)";
                $apps[$x]['db'][$y]['fields'][$z]['key']['type'] = "foreign";
                $apps[$x]['db'][$y]['fields'][$z]['key']['reference']['table'] = "v_extensions";
                $apps[$x]['db'][$y]['fields'][$z]['key']['reference']['field'] = "extension_uuid";
                $apps[$x]['db'][$y]['fields'][$z]['description']['en-us'] = "";
                $z++;
                $apps[$x]['db'][$y]['fields'][$z]['name']['text'] = "sitename";
                $apps[$x]['db'][$y]['fields'][$z]['type'] = "text";
                $apps[$x]['db'][$y]['fields'][$z]['description']['en'] = "Enter the site name.";
                $apps[$x]['db'][$y]['fields'][$z]['description']['pt-br'] = "Insira o número de site name.";
                $z++;
                $apps[$x]['db'][$y]['fields'][$z]['name']['text'] = "operator";
                $apps[$x]['db'][$y]['fields'][$z]['type'] = "text";
                $apps[$x]['db'][$y]['fields'][$z]['description']['en'] = "Enter the site operator number.";


                $y++;
                $apps[$x]['db'][$y]['table']['name'] = "v_extensions";
                $apps[$x]['db'][$y]['table']['parent'] = "v_extensions";
                $z=0;
                $apps[$x]['db'][$y]['fields'][$z]['name'] = "site_uuid";
                $apps[$x]['db'][$y]['fields'][$z]['uuid'] = "b48409dc-2fae-4e4e-9dba-05009b6ff40a";
                $apps[$x]['db'][$y]['fields'][$z]['type'] = "uuid";
                $apps[$x]['db'][$y]['fields'][$z]['description']['en-us'] = "";


?>

