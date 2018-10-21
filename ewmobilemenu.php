<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(4, "mmi_cf01_home_php", $Language->MenuPhrase("4", "MenuText"), "cf01_home.php", -1, "", AllowListMenu('{78A0660C-C398-4292-A50E-2A3C7D765239}cf01_home.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(5, "mmci_Setup", $Language->MenuPhrase("5", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(8, "mmi_t00_provinsi", $Language->MenuPhrase("8", "MenuText"), "t00_provinsilist.php", 5, "", AllowListMenu('{78A0660C-C398-4292-A50E-2A3C7D765239}t00_provinsi'), FALSE, FALSE);
$RootMenu->AddMenuItem(9, "mmi_t01_kabupatenkota", $Language->MenuPhrase("9", "MenuText"), "t01_kabupatenkotalist.php", 5, "", AllowListMenu('{78A0660C-C398-4292-A50E-2A3C7D765239}t01_kabupatenkota'), FALSE, FALSE);
$RootMenu->AddMenuItem(14, "mmi_t04_dapil", $Language->MenuPhrase("14", "MenuText"), "t04_dapillist.php", 5, "", AllowListMenu('{78A0660C-C398-4292-A50E-2A3C7D765239}t04_dapil'), FALSE, FALSE);
$RootMenu->AddMenuItem(12, "mmi_t02_kecamatan", $Language->MenuPhrase("12", "MenuText"), "t02_kecamatanlist.php", 5, "", AllowListMenu('{78A0660C-C398-4292-A50E-2A3C7D765239}t02_kecamatan'), FALSE, FALSE);
$RootMenu->AddMenuItem(13, "mmi_t03_kelurahan", $Language->MenuPhrase("13", "MenuText"), "t03_kelurahanlist.php", 5, "", AllowListMenu('{78A0660C-C398-4292-A50E-2A3C7D765239}t03_kelurahan'), FALSE, FALSE);
$RootMenu->AddMenuItem(15, "mmi_t05_tps", $Language->MenuPhrase("15", "MenuText"), "t05_tpslist.php", 5, "", AllowListMenu('{78A0660C-C398-4292-A50E-2A3C7D765239}t05_tps'), FALSE, FALSE);
$RootMenu->AddMenuItem(1, "mmi_t96_employees", $Language->MenuPhrase("1", "MenuText"), "t96_employeeslist.php", 5, "", AllowListMenu('{78A0660C-C398-4292-A50E-2A3C7D765239}t96_employees'), FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mmi_t97_userlevels", $Language->MenuPhrase("2", "MenuText"), "t97_userlevelslist.php", 5, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE, FALSE);
$RootMenu->AddMenuItem(3, "mmi_t98_userlevelpermissions", $Language->MenuPhrase("3", "MenuText"), "t98_userlevelpermissionslist.php", 5, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE, FALSE);
$RootMenu->AddMenuItem(10, "mmi_t94_log", $Language->MenuPhrase("10", "MenuText"), "t94_loglist.php", 5, "", AllowListMenu('{78A0660C-C398-4292-A50E-2A3C7D765239}t94_log'), FALSE, FALSE);
$RootMenu->AddMenuItem(7, "mmci_List", $Language->MenuPhrase("7", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(6, "mmi_t99_audittrail", $Language->MenuPhrase("6", "MenuText"), "t99_audittraillist.php", 7, "", AllowListMenu('{78A0660C-C398-4292-A50E-2A3C7D765239}t99_audittrail'), FALSE, FALSE);
$RootMenu->AddMenuItem(-2, "mmi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mmi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mmi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
