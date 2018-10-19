<!-- Begin Main Menu -->
<?php $RootMenu = new cMenu(EW_MENUBAR_ID) ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(4, "mi_cf01_home_php", $Language->MenuPhrase("4", "MenuText"), "cf01_home.php", -1, "", AllowListMenu('{78A0660C-C398-4292-A50E-2A3C7D765239}cf01_home.php'), FALSE, TRUE);
$RootMenu->AddMenuItem(5, "mci_Setup", $Language->MenuPhrase("5", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(1, "mi_t96_employees", $Language->MenuPhrase("1", "MenuText"), "t96_employeeslist.php", 5, "", AllowListMenu('{78A0660C-C398-4292-A50E-2A3C7D765239}t96_employees'), FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mi_t97_userlevels", $Language->MenuPhrase("2", "MenuText"), "t97_userlevelslist.php", 5, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE, FALSE);
$RootMenu->AddMenuItem(3, "mi_t98_userlevelpermissions", $Language->MenuPhrase("3", "MenuText"), "t98_userlevelpermissionslist.php", 5, "", (@$_SESSION[EW_SESSION_USER_LEVEL] & EW_ALLOW_ADMIN) == EW_ALLOW_ADMIN, FALSE, FALSE);
$RootMenu->AddMenuItem(7, "mci_List", $Language->MenuPhrase("7", "MenuText"), "", -1, "", IsLoggedIn(), FALSE, TRUE);
$RootMenu->AddMenuItem(6, "mi_t99_audittrail", $Language->MenuPhrase("6", "MenuText"), "t99_audittraillist.php", 7, "", AllowListMenu('{78A0660C-C398-4292-A50E-2A3C7D765239}t99_audittrail'), FALSE, FALSE);
$RootMenu->AddMenuItem(-2, "mi_changepwd", $Language->Phrase("ChangePwd"), "changepwd.php", -1, "", IsLoggedIn() && !IsSysAdmin());
$RootMenu->AddMenuItem(-1, "mi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
