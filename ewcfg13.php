<?php
/**
 * PHPMaker 2017 configuration file
 */

// Relative path
if (!isset($EW_RELATIVE_PATH)) $EW_RELATIVE_PATH = "";

// Show SQL for debug
define("EW_DEBUG_ENABLED", FALSE, TRUE); // TRUE to debug
if (EW_DEBUG_ENABLED) {
	@ini_set("display_errors", "1"); // Display errors
	error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE
}

// General
define("EW_IS_WINDOWS", (strtolower(substr(PHP_OS, 0, 3)) === 'win'), TRUE); // Is Windows OS
define("EW_IS_PHP5", (phpversion() >= "5.3.0"), TRUE); // Is PHP 5.3 or later
if (!EW_IS_PHP5) die("This script requires PHP 5.3 or later. You are running " . phpversion() . ".");
define("EW_PATH_DELIMITER", ((EW_IS_WINDOWS) ? "\\" : "/"), TRUE); // Physical path delimiter
$EW_ROOT_RELATIVE_PATH = "."; // Relative path of app root
define("EW_UNFORMAT_YEAR", 50, TRUE); // Unformat year
define("EW_PROJECT_NAME", "simddpt_prj", TRUE); // Project name
define("EW_CONFIG_FILE_FOLDER", EW_PROJECT_NAME, TRUE); // Config file name
define("EW_PROJECT_ID", "{78A0660C-C398-4292-A50E-2A3C7D765239}", TRUE); // Project ID (GUID)
$EW_RELATED_PROJECT_ID = "";
$EW_RELATED_LANGUAGE_FOLDER = "";
define("EW_RANDOM_KEY", 'eehBKEWc4y7Gf6F5', TRUE); // Random key for encryption
define("EW_PROJECT_STYLESHEET_FILENAME", "phpcss/simddpt_prj.css", TRUE); // Project stylesheet file name
define("EW_CHARSET", "", TRUE); // Project charset
define("EW_EMAIL_CHARSET", EW_CHARSET, TRUE); // Email charset
define("EW_EMAIL_KEYWORD_SEPARATOR", "", TRUE); // Email keyword separator
$EW_COMPOSITE_KEY_SEPARATOR = ","; // Composite key separator
define("EW_HIGHLIGHT_COMPARE", TRUE, TRUE); // Highlight compare mode, TRUE(case-insensitive)|FALSE(case-sensitive)
if (!function_exists('xml_parser_create') && !class_exists("DOMDocument")) die("This script requires PHP XML Parser or DOM.");
define('EW_USE_DOM_XML', ((!function_exists('xml_parser_create') && class_exists("DOMDocument")) || FALSE), TRUE);
if (!isset($ADODB_OUTP)) $ADODB_OUTP = 'ew_SetDebugMsg';
define("EW_FONT_SIZE", 11, TRUE);
define("EW_TMP_IMAGE_FONT", "DejaVuSans", TRUE); // Font for temp files

// Set up font path
$EW_FONT_PATH = realpath('./phpfont');

// Database connection info
if (!defined("EW_USE_ADODB"))
	define("EW_USE_ADODB", FALSE, TRUE); // Use ADOdb
if (!defined("EW_ADODB_TZ_OFFSET"))
	define("EW_ADODB_TZ_OFFSET", FALSE, TRUE); // Use ADOdb time zone offset
if (!defined("EW_USE_MYSQLI"))
	define('EW_USE_MYSQLI', extension_loaded("mysqli"), TRUE); // Use MySQLi
$EW_CONN["DB"] = array("conn" => NULL, "id" => "DB", "type" => "MYSQL", "host" => "localhost", "port" => 3306, "user" => "root", "pass" => "admin", "db" => "db_simddpt", "qs" => "`", "qe" => "`");
$EW_CONN[0] = &$EW_CONN["DB"];

// Set up database error function
$EW_ERROR_FN = 'ew_ErrorFn';

// ADODB (Access/SQL Server)
define("EW_CODEPAGE", 0, TRUE); // Code page
/**
 * Character encoding
 * Note: If you use non English languages, you need to set character encoding
 * for some features. Make sure either iconv functions or multibyte string
 * functions are enabled and your encoding is supported. See PHP manual for
 * details.
 */
define("EW_ENCODING", "", TRUE); // Character encoding
define("EW_IS_DOUBLE_BYTE", in_array(EW_ENCODING, array("GBK", "BIG5", "SHIFT_JIS")), TRUE); // Double-byte character encoding
define("EW_FILE_SYSTEM_ENCODING", "", TRUE); // File system encoding

// Database
define("EW_IS_MSACCESS", FALSE, TRUE); // Access
define("EW_IS_MSSQL", FALSE, TRUE); // SQL Server
define("EW_IS_MYSQL", TRUE, TRUE); // MySQL
define("EW_IS_POSTGRESQL", FALSE, TRUE); // PostgreSQL
define("EW_IS_ORACLE", FALSE, TRUE); // Oracle
if (!EW_IS_WINDOWS && (EW_IS_MSACCESS || EW_IS_MSSQL))
	die("Microsoft Access or SQL Server is supported on Windows server only.");
define("EW_DB_QUOTE_START", "`", TRUE);
define("EW_DB_QUOTE_END", "`", TRUE);
/**
 * MySQL charset (for SET NAMES statement, not used by default)
 * Note: Read http://dev.mysql.com/doc/refman/5.0/en/charset-connection.html
 * before using this setting.
 */
define("EW_MYSQL_CHARSET", "", TRUE);
/**
 * Password (MD5 and case-sensitivity)
 * Note: If you enable MD5 password, make sure that the passwords in your
 * user table are stored as MD5 hash (32-character hexadecimal number) of the
 * clear text password. If you also use case-insensitive password, convert the
 * clear text passwords to lower case first before calculating MD5 hash.
 * Otherwise, existing users will not be able to login. MD5 hash is
 * irreversible, password will be reset during password recovery.
 */
define("EW_ENCRYPTED_PASSWORD", TRUE, TRUE); // Use encrypted password
define("EW_CASE_SENSITIVE_PASSWORD", TRUE, TRUE); // Case-sensitive password
/**
 * Remove XSS
 * Note: If you want to allow these keywords, remove them from the following EW_XSS_ARRAY at your own risks.
*/
define("EW_REMOVE_XSS", TRUE, TRUE);
$EW_XSS_ARRAY = array('javascript', 'vbscript', 'expression', '<applet', '<meta', '<xml', '<blink', '<link', '<style', '<script', '<embed', '<object', '<iframe', '<frame', '<frameset', '<ilayer', '<layer', '<bgsound', '<title', '<base',
'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');

// Check Token
define("EW_CHECK_TOKEN", TRUE, TRUE); // Check post token

// Session timeout time
define("EW_SESSION_TIMEOUT", 0, TRUE); // Session timeout time (minutes)

// Session keep alive interval
define("EW_SESSION_KEEP_ALIVE_INTERVAL", 0, TRUE); // Session keep alive interval (seconds)
define("EW_SESSION_TIMEOUT_COUNTDOWN", 60, TRUE); // Session timeout count down interval (seconds)

// Session names
define("EW_SESSION_STATUS", EW_PROJECT_NAME . "_status", TRUE); // Login status
define("EW_SESSION_USER_NAME", EW_SESSION_STATUS . "_UserName", TRUE); // User name
define("EW_SESSION_USER_LOGIN_TYPE", EW_SESSION_STATUS . "_UserLoginType", TRUE); // User login type
define("EW_SESSION_USER_ID", EW_SESSION_STATUS . "_UserID", TRUE); // User ID
define("EW_SESSION_USER_PROFILE", EW_SESSION_STATUS . "_UserProfile", TRUE); // User profile
define("EW_SESSION_USER_PROFILE_USER_NAME", EW_SESSION_USER_PROFILE . "_UserName", TRUE);
define("EW_SESSION_USER_PROFILE_PASSWORD", EW_SESSION_USER_PROFILE . "_Password", TRUE);
define("EW_SESSION_USER_PROFILE_LOGIN_TYPE", EW_SESSION_USER_PROFILE . "_LoginType", TRUE);
define("EW_SESSION_USER_LEVEL_ID", EW_SESSION_STATUS . "_UserLevel", TRUE); // User Level ID
define("EW_SESSION_USER_LEVEL_LIST", EW_SESSION_STATUS . "_UserLevelList", TRUE); // User Level List
define("EW_SESSION_USER_LEVEL_LIST_LOADED", EW_SESSION_STATUS . "_UserLevelListLoaded", TRUE); // User Level List Loaded
@define("EW_SESSION_USER_LEVEL", EW_SESSION_STATUS . "_UserLevelValue", TRUE); // User Level
define("EW_SESSION_PARENT_USER_ID", EW_SESSION_STATUS . "_ParentUserID", TRUE); // Parent User ID
define("EW_SESSION_SYS_ADMIN", EW_PROJECT_NAME . "_SysAdmin", TRUE); // System admin
define("EW_SESSION_PROJECT_ID", EW_PROJECT_NAME . "_ProjectID", TRUE); // User Level project ID
define("EW_SESSION_AR_USER_LEVEL", EW_PROJECT_NAME . "_arUserLevel", TRUE); // User Level array
define("EW_SESSION_AR_USER_LEVEL_PRIV", EW_PROJECT_NAME . "_arUserLevelPriv", TRUE); // User Level privilege array
define("EW_SESSION_USER_LEVEL_MSG", EW_PROJECT_NAME . "_UserLevelMessage", TRUE); // User Level Message
define("EW_SESSION_MESSAGE", EW_PROJECT_NAME . "_Message", TRUE); // System message
define("EW_SESSION_FAILURE_MESSAGE", EW_PROJECT_NAME . "_Failure_Message", TRUE); // System error message
define("EW_SESSION_SUCCESS_MESSAGE", EW_PROJECT_NAME . "_Success_Message", TRUE); // System message
define("EW_SESSION_WARNING_MESSAGE", EW_PROJECT_NAME . "_Warning_Message", TRUE); // Warning message
define("EW_SESSION_INLINE_MODE", EW_PROJECT_NAME . "_InlineMode", TRUE); // Inline mode
define("EW_SESSION_BREADCRUMB", EW_PROJECT_NAME . "_Breadcrumb", TRUE); // Breadcrumb
define("EW_SESSION_TEMP_IMAGES", EW_PROJECT_NAME . "_TempImages", TRUE); // Temp images

// Language settings
define("EW_LANGUAGE_FOLDER", $EW_RELATIVE_PATH . "phplang/", TRUE);
$EW_LANGUAGE_FILE = array();
$EW_LANGUAGE_FILE[] = array("en", "", "english.xml");
define("EW_LANGUAGE_DEFAULT_ID", "en", TRUE);
define("EW_SESSION_LANGUAGE_ID", EW_PROJECT_NAME . "_LanguageId", TRUE); // Language ID
define("EW_LOCALE_FOLDER", $EW_RELATIVE_PATH . "phplocale/", TRUE);

// Page Token
define("EW_TOKEN_NAME", "token", TRUE); // DO NOT CHANGE!
define("EW_SESSION_TOKEN", EW_PROJECT_NAME . "_Token", TRUE);

// Data types
define("EW_DATATYPE_NUMBER", 1, TRUE);
define("EW_DATATYPE_DATE", 2, TRUE);
define("EW_DATATYPE_STRING", 3, TRUE);
define("EW_DATATYPE_BOOLEAN", 4, TRUE);
define("EW_DATATYPE_MEMO", 5, TRUE);
define("EW_DATATYPE_BLOB", 6, TRUE);
define("EW_DATATYPE_TIME", 7, TRUE);
define("EW_DATATYPE_GUID", 8, TRUE);
define("EW_DATATYPE_XML", 9, TRUE);
define("EW_DATATYPE_OTHER", 10, TRUE);

// Row types
define("EW_ROWTYPE_HEADER", 0, TRUE); // Row type header
define("EW_ROWTYPE_VIEW", 1, TRUE); // Row type view
define("EW_ROWTYPE_ADD", 2, TRUE); // Row type add
define("EW_ROWTYPE_EDIT", 3, TRUE); // Row type edit
define("EW_ROWTYPE_SEARCH", 4, TRUE); // Row type search
define("EW_ROWTYPE_MASTER", 5, TRUE); // Row type master record
define("EW_ROWTYPE_AGGREGATEINIT", 6, TRUE); // Row type aggregate init
define("EW_ROWTYPE_AGGREGATE", 7, TRUE); // Row type aggregate

// List actions
define("EW_ACTION_POSTBACK", "P", TRUE); // Post back
define("EW_ACTION_AJAX", "A", TRUE); // Ajax
define("EW_ACTION_MULTIPLE", "M", TRUE); // Multiple records
define("EW_ACTION_SINGLE", "S", TRUE); // Single record

// Table parameters
define("EW_TABLE_PREFIX", "||PHPReportMaker||", TRUE); // For backward compatibilty only
define("EW_TABLE_REC_PER_PAGE", "recperpage", TRUE); // Records per page
define("EW_TABLE_START_REC", "start", TRUE); // Start record
define("EW_TABLE_PAGE_NO", "pageno", TRUE); // Page number
define("EW_TABLE_BASIC_SEARCH", "psearch", TRUE); // Basic search keyword
define("EW_TABLE_BASIC_SEARCH_TYPE","psearchtype", TRUE); // Basic search type
define("EW_TABLE_ADVANCED_SEARCH", "advsrch", TRUE); // Advanced search
define("EW_TABLE_SEARCH_WHERE", "searchwhere", TRUE); // Search where clause
define("EW_TABLE_WHERE", "where", TRUE); // Table where
define("EW_TABLE_WHERE_LIST", "where_list", TRUE); // Table where (list page)
define("EW_TABLE_ORDER_BY", "orderby", TRUE); // Table order by
define("EW_TABLE_ORDER_BY_LIST", "orderby_list", TRUE); // Table order by (list page)
define("EW_TABLE_SORT", "sort", TRUE); // Table sort
define("EW_TABLE_KEY", "key", TRUE); // Table key
define("EW_TABLE_SHOW_MASTER", "showmaster", TRUE); // Table show master
define("EW_TABLE_SHOW_DETAIL", "showdetail", TRUE); // Table show detail
define("EW_TABLE_MASTER_TABLE", "mastertable", TRUE); // Master table
define("EW_TABLE_DETAIL_TABLE", "detailtable", TRUE); // Detail table
define("EW_TABLE_RETURN_URL", "return", TRUE); // Return URL
define("EW_TABLE_EXPORT_RETURN_URL", "exportreturn", TRUE); // Export return URL
define("EW_TABLE_GRID_ADD_ROW_COUNT", "gridaddcnt", TRUE); // Grid add row count

// Audit Trail
define("EW_AUDIT_TRAIL_TO_DATABASE", TRUE, TRUE); // Write audit trail to DB
define("EW_AUDIT_TRAIL_DBID", "DB", TRUE); // Audit trail DBID
define("EW_AUDIT_TRAIL_TABLE_NAME", "t99_audittrail", TRUE); // Audit trail table name
define("EW_AUDIT_TRAIL_TABLE_VAR", "t99_audittrail", TRUE); // Audit trail table var
define("EW_AUDIT_TRAIL_FIELD_NAME_DATETIME", "datetime", TRUE); // Audit trail DateTime field name
define("EW_AUDIT_TRAIL_FIELD_NAME_SCRIPT", "script", TRUE); // Audit trail Script field name
define("EW_AUDIT_TRAIL_FIELD_NAME_USER", "user", TRUE); // Audit trail User field name
define("EW_AUDIT_TRAIL_FIELD_NAME_ACTION", "action", TRUE); // Audit trail Action field name
define("EW_AUDIT_TRAIL_FIELD_NAME_TABLE", "table", TRUE); // Audit trail Table field name
define("EW_AUDIT_TRAIL_FIELD_NAME_FIELD", "field", TRUE); // Audit trail Field field name
define("EW_AUDIT_TRAIL_FIELD_NAME_KEYVALUE", "keyvalue", TRUE); // Audit trail Key Value field name
define("EW_AUDIT_TRAIL_FIELD_NAME_OLDVALUE", "oldvalue", TRUE); // Audit trail Old Value field name
define("EW_AUDIT_TRAIL_FIELD_NAME_NEWVALUE", "newvalue", TRUE); // Audit trail New Value field name

// Security
define("EW_ADMIN_USER_NAME", "", TRUE); // Administrator user name
define("EW_ADMIN_PASSWORD", "", TRUE); // Administrator password
define("EW_USE_CUSTOM_LOGIN", TRUE, TRUE); // Use custom login
define("EW_ALLOW_LOGIN_BY_URL", FALSE, TRUE); // Allow login by URL
define("EW_ALLOW_LOGIN_BY_SESSION", FALSE, TRUE); // Allow login by session variables
define("EW_PHPASS_ITERATION_COUNT_LOG2", "[10,8]", TRUE); // Note: Use JSON array syntax

// Dynamic User Level settings
// User level definition table/field names

@define("EW_USER_LEVEL_DBID", "DB", TRUE);
@define("EW_USER_LEVEL_TABLE", "`t97_userlevels`", TRUE);
@define("EW_USER_LEVEL_ID_FIELD", "`userlevelid`", TRUE);
@define("EW_USER_LEVEL_NAME_FIELD", "`userlevelname`", TRUE);

// User Level privileges table/field names
@define("EW_USER_LEVEL_PRIV_DBID", "DB", TRUE);
@define("EW_USER_LEVEL_PRIV_TABLE", "`t98_userlevelpermissions`", TRUE);
@define("EW_USER_LEVEL_PRIV_TABLE_NAME_FIELD", "`tablename`", TRUE);
@define("EW_USER_LEVEL_PRIV_TABLE_NAME_FIELD_2", "tablename", TRUE);
@define("EW_USER_LEVEL_PRIV_TABLE_NAME_FIELD_SIZE", 255, TRUE);
@define("EW_USER_LEVEL_PRIV_USER_LEVEL_ID_FIELD", "`userlevelid`", TRUE);
@define("EW_USER_LEVEL_PRIV_PRIV_FIELD", "`permission`", TRUE);

// User level constants
define("EW_ALLOW_ADD", 1, TRUE); // Add
define("EW_ALLOW_DELETE", 2, TRUE); // Delete
define("EW_ALLOW_EDIT", 4, TRUE); // Edit
@define("EW_ALLOW_LIST", 8, TRUE); // List
if (defined("EW_USER_LEVEL_COMPAT")) {
	define("EW_ALLOW_VIEW", 8, TRUE); // View
	define("EW_ALLOW_SEARCH", 8, TRUE); // Search
} else {
	define("EW_ALLOW_VIEW", 32, TRUE); // View
	define("EW_ALLOW_SEARCH", 64, TRUE); // Search
}
@define("EW_ALLOW_REPORT", 8, TRUE); // Report
@define("EW_ALLOW_ADMIN", 16, TRUE); // Admin

// Hierarchical User ID
@define("EW_USER_ID_IS_HIERARCHICAL", TRUE, TRUE); // Change to FALSE to show one level only

// Use subquery for master/detail
define("EW_USE_SUBQUERY_FOR_MASTER_USER_ID", FALSE, TRUE);
define("EW_USER_ID_ALLOW", 104, TRUE);

// User table filters
define("EW_USER_TABLE_DBID", "DB", TRUE);
define("EW_USER_TABLE", "`t96_employees`", TRUE);
define("EW_USER_NAME_FILTER", "(`Username` = '%u')", TRUE);
define("EW_USER_ID_FILTER", "(`EmployeeID` = %u)", TRUE);
define("EW_USER_EMAIL_FILTER", "", TRUE);
define("EW_USER_ACTIVATE_FILTER", "", TRUE);

// User Profile Constants
define("EW_USER_PROFILE_KEY_SEPARATOR", "", TRUE);
define("EW_USER_PROFILE_FIELD_SEPARATOR", "", TRUE);
define("EW_USER_PROFILE_SESSION_ID", "SessionID", TRUE);
define("EW_USER_PROFILE_LAST_ACCESSED_DATE_TIME", "LastAccessedDateTime", TRUE);
define("EW_USER_PROFILE_CONCURRENT_SESSION_COUNT", 1, TRUE); // Maximum sessions allowed
define("EW_USER_PROFILE_SESSION_TIMEOUT", 20, TRUE);
define("EW_USER_PROFILE_LOGIN_RETRY_COUNT", "LoginRetryCount", TRUE);
define("EW_USER_PROFILE_LAST_BAD_LOGIN_DATE_TIME", "LastBadLoginDateTime", TRUE);
define("EW_USER_PROFILE_MAX_RETRY", 3, TRUE);
define("EW_USER_PROFILE_RETRY_LOCKOUT", 20, TRUE);
define("EW_USER_PROFILE_LAST_PASSWORD_CHANGED_DATE", "LastPasswordChangedDate", TRUE);
define("EW_USER_PROFILE_PASSWORD_EXPIRE", 90, TRUE);
define("EW_USER_PROFILE_LANGUAGE_ID", "LanguageId", TRUE);
define("EW_USER_PROFILE_SEARCH_FILTERS", "SearchFilters", TRUE);
define("EW_SEARCH_FILTER_OPTION", "Client", TRUE);

// Auto hide pager
define("EW_AUTO_HIDE_PAGER", TRUE, TRUE);
define("EW_AUTO_HIDE_PAGE_SIZE_SELECTOR", FALSE, TRUE);

// Email
define("EW_SMTP_SERVER", "localhost", TRUE); // SMTP server
define("EW_SMTP_SERVER_PORT", 25, TRUE); // SMTP server port
define("EW_SMTP_SECURE_OPTION", "", TRUE);
define("EW_SMTP_SERVER_USERNAME", "", TRUE); // SMTP server user name
define("EW_SMTP_SERVER_PASSWORD", "", TRUE); // SMTP server password
define("EW_SENDER_EMAIL", "", TRUE); // Sender email address
define("EW_RECIPIENT_EMAIL", "", TRUE); // Recipient email address
define("EW_MAX_EMAIL_RECIPIENT", 3, TRUE);
define("EW_MAX_EMAIL_SENT_COUNT", 3, TRUE);
define("EW_EXPORT_EMAIL_COUNTER", EW_SESSION_STATUS . "_EmailCounter", TRUE);
define("EW_EMAIL_CHANGEPWD_TEMPLATE", "changepwd.html", TRUE);
define("EW_EMAIL_FORGOTPWD_TEMPLATE", "forgotpwd.html", TRUE);
define("EW_EMAIL_NOTIFY_TEMPLATE", "notify.html", TRUE);
define("EW_EMAIL_REGISTER_TEMPLATE", "register.html", TRUE);
define("EW_EMAIL_RESETPWD_TEMPLATE", "resetpwd.html", TRUE);
define("EW_EMAIL_TEMPLATE_PATH", "phphtml", TRUE); // Template path

// File upload
define("EW_UPLOAD_TEMP_PATH", "", TRUE); // Upload temp path (absolute)
define("EW_UPLOAD_DEST_PATH", "", TRUE); // Upload destination path (relative to app root)
define("EW_UPLOAD_URL", "ewupload13.php", TRUE); // Upload URL
define("EW_UPLOAD_TEMP_FOLDER_PREFIX", "temp__", TRUE); // Upload temp folders prefix
define("EW_UPLOAD_TEMP_FOLDER_TIME_LIMIT", 1440, TRUE); // Upload temp folder time limit (minutes)
define("EW_UPLOAD_THUMBNAIL_FOLDER", "thumbnail", TRUE); // Temporary thumbnail folder
define("EW_UPLOAD_THUMBNAIL_WIDTH", 200, TRUE); // Temporary thumbnail max width
define("EW_UPLOAD_THUMBNAIL_HEIGHT", 0, TRUE); // Temporary thumbnail max height
define("EW_UPLOAD_ALLOWED_FILE_EXT", "gif,jpg,jpeg,bmp,png,doc,docx,xls,xlsx,pdf,zip", TRUE); // Allowed file extensions
define("EW_IMAGE_ALLOWED_FILE_EXT", "gif,jpg,png,bmp", TRUE); // Allowed file extensions for images
define("EW_DOWNLOAD_ALLOWED_FILE_EXT", "pdf,xls,doc,xlsx,docx", TRUE); // Allowed file extensions for download (non-image)
define("EW_ENCRYPT_FILE_PATH", TRUE, TRUE); // Encrypt file path
define("EW_MAX_FILE_SIZE", 2000000, TRUE); // Max file size
define("EW_MAX_FILE_COUNT", 0, TRUE); // Max file count
define("EW_THUMBNAIL_DEFAULT_WIDTH", 0, TRUE); // Thumbnail default width
define("EW_THUMBNAIL_DEFAULT_HEIGHT", 0, TRUE); // Thumbnail default height
define("EW_THUMBNAIL_DEFAULT_QUALITY", 100, TRUE); // Thumbnail default qualtity (JPEG)
define("EW_UPLOADED_FILE_MODE", 0666, TRUE); // Uploaded file mode
define("EW_UPLOAD_TMP_PATH", "", TRUE); // User upload temp path (relative to app root) e.g. "tmp/"
define("EW_UPLOAD_CONVERT_ACCENTED_CHARS", FALSE, TRUE); // Convert accented chars in upload file name
define("EW_USE_COLORBOX", TRUE, TRUE); // Use Colorbox
define("EW_MULTIPLE_UPLOAD_SEPARATOR", ",", TRUE); // Multiple upload separator

// Image resize
$EW_THUMBNAIL_CLASS = "cThumbnail";
define("EW_REDUCE_IMAGE_ONLY", TRUE, TRUE);
define("EW_KEEP_ASPECT_RATIO", FALSE, TRUE);
$EW_RESIZE_OPTIONS = array("keepAspectRatio" => EW_KEEP_ASPECT_RATIO, "resizeUp" => !EW_REDUCE_IMAGE_ONLY, "jpegQuality" => EW_THUMBNAIL_DEFAULT_QUALITY);

// Audit trail
define("EW_AUDIT_TRAIL_PATH", "", TRUE); // Audit trail path (relative to app root)

// Export records
define("EW_EXPORT_ALL", TRUE, TRUE); // Export all records
define("EW_EXPORT_ALL_TIME_LIMIT", 120, TRUE); // Export all records time limit
define("EW_XML_ENCODING", "utf-8", TRUE); // Encoding for Export to XML
define("EW_EXPORT_ORIGINAL_VALUE", FALSE, TRUE);
define("EW_EXPORT_FIELD_CAPTION", FALSE, TRUE); // TRUE to export field caption
define("EW_EXPORT_CSS_STYLES", TRUE, TRUE); // TRUE to export CSS styles
define("EW_EXPORT_MASTER_RECORD", TRUE, TRUE); // TRUE to export master record
define("EW_EXPORT_MASTER_RECORD_FOR_CSV", FALSE, TRUE); // TRUE to export master record for CSV
define("EW_EXPORT_DETAIL_RECORDS", TRUE, TRUE); // TRUE to export detail records
define("EW_EXPORT_DETAIL_RECORDS_FOR_CSV", FALSE, TRUE); // TRUE to export detail records for CSV
$EW_EXPORT = array(
	"email" => "cExportEmail",
	"html" => "cExportHtml",
	"word" => "cExportWord",
	"excel" => "cExportExcel",
	"pdf" => "cExportPdf",
	"csv" => "cExportCsv",
	"xml" => "cExportXml"
);

// Export records for reports
$EW_EXPORT_REPORT = array(
	"print" => "ExportReportHtml",
	"html" => "ExportReportHtml",
	"word" => "ExportReportWord",
	"excel" => "ExportReportExcel"
);

// MIME types
$EW_MIME_TYPES = array(
	"323" => "text/h323",
	"3g2" => "video/3gpp2",
	"3gp2" => "video/3gpp2",
	"3gp" => "video/3gpp",
	"3gpp" => "video/3gpp",
	"aac" => "audio/aac",
	"aaf" => "application/octet-stream",
	"aca" => "application/octet-stream",
	"accdb" => "application/msaccess",
	"accde" => "application/msaccess",
	"accdt" => "application/msaccess",
	"acx" => "application/internet-property-stream",
	"adt" => "audio/vnd.dlna.adts",
	"adts" => "audio/vnd.dlna.adts",
	"afm" => "application/octet-stream",
	"ai" => "application/postscript",
	"aif" => "audio/x-aiff",
	"aifc" => "audio/aiff",
	"aiff" => "audio/aiff",
	"appcache" => "text/cache-manifest",
	"application" => "application/x-ms-application",
	"art" => "image/x-jg",
	"asd" => "application/octet-stream",
	"asf" => "video/x-ms-asf",
	"asi" => "application/octet-stream",
	"asm" => "text/plain",
	"asr" => "video/x-ms-asf",
	"asx" => "video/x-ms-asf",
	"atom" => "application/atom+xml",
	"au" => "audio/basic",
	"avi" => "video/x-msvideo",
	"axs" => "application/olescript",
	"bas" => "text/plain",
	"bcpio" => "application/x-bcpio",
	"bin" => "application/octet-stream",
	"bmp" => "image/bmp",
	"c" => "text/plain",
	"cab" => "application/vnd.ms-cab-compressed",
	"calx" => "application/vnd.ms-office.calx",
	"cat" => "application/vnd.ms-pki.seccat",
	"cdf" => "application/x-cdf",
	"chm" => "application/octet-stream",
	"class" => "application/x-java-applet",
	"clp" => "application/x-msclip",
	"cmx" => "image/x-cmx",
	"cnf" => "text/plain",
	"cod" => "image/cis-cod",
	"cpio" => "application/x-cpio",
	"cpp" => "text/plain",
	"crd" => "application/x-mscardfile",
	"crl" => "application/pkix-crl",
	"crt" => "application/x-x509-ca-cert",
	"csh" => "application/x-csh",
	"css" => "text/css",
	"csv" => "application/octet-stream",
	"cur" => "application/octet-stream",
	"dcr" => "application/x-director",
	"deploy" => "application/octet-stream",
	"der" => "application/x-x509-ca-cert",
	"dib" => "image/bmp",
	"dir" => "application/x-director",
	"disco" => "text/xml",
	"dlm" => "text/dlm",
	"doc" => "application/msword",
	"docm" => "application/vnd.ms-word.document.macroEnabled.12",
	"docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
	"dot" => "application/msword",
	"dotm" => "application/vnd.ms-word.template.macroEnabled.12",
	"dotx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.template",
	"dsp" => "application/octet-stream",
	"dtd" => "text/xml",
	"dvi" => "application/x-dvi",
	"dvr-ms" => "video/x-ms-dvr",
	"dwf" => "drawing/x-dwf",
	"dwp" => "application/octet-stream",
	"dxr" => "application/x-director",
	"eml" => "message/rfc822",
	"emz" => "application/octet-stream",
	"eot" => "application/vnd.ms-fontobject",
	"eps" => "application/postscript",
	"etx" => "text/x-setext",
	"evy" => "application/envoy",
	"fdf" => "application/vnd.fdf",
	"fif" => "application/fractals",
	"fla" => "application/octet-stream",
	"flr" => "x-world/x-vrml",
	"flv" => "video/x-flv",
	"gif" => "image/gif",
	"gtar" => "application/x-gtar",
	"gz" => "application/x-gzip",
	"h" => "text/plain",
	"hdf" => "application/x-hdf",
	"hdml" => "text/x-hdml",
	"hhc" => "application/x-oleobject",
	"hhk" => "application/octet-stream",
	"hhp" => "application/octet-stream",
	"hlp" => "application/winhlp",
	"hqx" => "application/mac-binhex40",
	"hta" => "application/hta",
	"htc" => "text/x-component",
	"htm" => "text/html",
	"html" => "text/html",
	"htt" => "text/webviewhtml",
	"hxt" => "text/html",
	"ical" => "text/calendar",
	"icalendar" => "text/calendar",
	"ico" => "image/x-icon",
	"ics" => "text/calendar",
	"ief" => "image/ief",
	"ifb" => "text/calendar",
	"iii" => "application/x-iphone",
	"inf" => "application/octet-stream",
	"ins" => "application/x-internet-signup",
	"isp" => "application/x-internet-signup",
	"IVF" => "video/x-ivf",
	"jar" => "application/java-archive",
	"java" => "application/octet-stream",
	"jck" => "application/liquidmotion",
	"jcz" => "application/liquidmotion",
	"jfif" => "image/pjpeg",
	"jpb" => "application/octet-stream",
	"jpe" => "image/jpeg",
	"jpeg" => "image/jpeg",
	"jpg" => "image/jpeg",
	"js" => "application/javascript",
	"json" => "application/json",
	"jsx" => "text/jscript",
	"latex" => "application/x-latex",
	"lit" => "application/x-ms-reader",
	"lpk" => "application/octet-stream",
	"lsf" => "video/x-la-asf",
	"lsx" => "video/x-la-asf",
	"lzh" => "application/octet-stream",
	"m13" => "application/x-msmediaview",
	"m14" => "application/x-msmediaview",
	"m1v" => "video/mpeg",
	"m2ts" => "video/vnd.dlna.mpeg-tts",
	"m3u" => "audio/x-mpegurl",
	"m4a" => "audio/mp4",
	"m4v" => "video/mp4",
	"man" => "application/x-troff-man",
	"manifest" => "application/x-ms-manifest",
	"map" => "text/plain",
	"mdb" => "application/x-msaccess",
	"mdp" => "application/octet-stream",
	"me" => "application/x-troff-me",
	"mht" => "message/rfc822",
	"mhtml" => "message/rfc822",
	"mid" => "audio/mid",
	"midi" => "audio/mid",
	"mix" => "application/octet-stream",
	"mmf" => "application/x-smaf",
	"mno" => "text/xml",
	"mny" => "application/x-msmoney",
	"mov" => "video/quicktime",
	"movie" => "video/x-sgi-movie",
	"mp2" => "video/mpeg",
	"mp3" => "audio/mpeg",
	"mp4" => "video/mp4",
	"mp4v" => "video/mp4",
	"mpa" => "video/mpeg",
	"mpe" => "video/mpeg",
	"mpeg" => "video/mpeg",
	"mpg" => "video/mpeg",
	"mpp" => "application/vnd.ms-project",
	"mpv2" => "video/mpeg",
	"ms" => "application/x-troff-ms",
	"msi" => "application/octet-stream",
	"mso" => "application/octet-stream",
	"mvb" => "application/x-msmediaview",
	"mvc" => "application/x-miva-compiled",
	"nc" => "application/x-netcdf",
	"nsc" => "video/x-ms-asf",
	"nws" => "message/rfc822",
	"ocx" => "application/octet-stream",
	"oda" => "application/oda",
	"odc" => "text/x-ms-odc",
	"ods" => "application/oleobject",
	"oga" => "audio/ogg",
	"ogg" => "video/ogg",
	"ogv" => "video/ogg",
	"ogx" => "application/ogg",
	"one" => "application/onenote",
	"onea" => "application/onenote",
	"onetoc" => "application/onenote",
	"onetoc2" => "application/onenote",
	"onetmp" => "application/onenote",
	"onepkg" => "application/onenote",
	"osdx" => "application/opensearchdescription+xml",
	"otf" => "font/otf",
	"p10" => "application/pkcs10",
	"p12" => "application/x-pkcs12",
	"p7b" => "application/x-pkcs7-certificates",
	"p7c" => "application/pkcs7-mime",
	"p7m" => "application/pkcs7-mime",
	"p7r" => "application/x-pkcs7-certreqresp",
	"p7s" => "application/pkcs7-signature",
	"pbm" => "image/x-portable-bitmap",
	"pcx" => "application/octet-stream",
	"pcz" => "application/octet-stream",
	"pdf" => "application/pdf",
	"pfb" => "application/octet-stream",
	"pfm" => "application/octet-stream",
	"pfx" => "application/x-pkcs12",
	"pgm" => "image/x-portable-graymap",
	"pko" => "application/vnd.ms-pki.pko",
	"pma" => "application/x-perfmon",
	"pmc" => "application/x-perfmon",
	"pml" => "application/x-perfmon",
	"pmr" => "application/x-perfmon",
	"pmw" => "application/x-perfmon",
	"png" => "image/png",
	"pnm" => "image/x-portable-anymap",
	"pnz" => "image/png",
	"pot" => "application/vnd.ms-powerpoint",
	"potm" => "application/vnd.ms-powerpoint.template.macroEnabled.12",
	"potx" => "application/vnd.openxmlformats-officedocument.presentationml.template",
	"ppam" => "application/vnd.ms-powerpoint.addin.macroEnabled.12",
	"ppm" => "image/x-portable-pixmap",
	"pps" => "application/vnd.ms-powerpoint",
	"ppsm" => "application/vnd.ms-powerpoint.slideshow.macroEnabled.12",
	"ppsx" => "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
	"ppt" => "application/vnd.ms-powerpoint",
	"pptm" => "application/vnd.ms-powerpoint.presentation.macroEnabled.12",
	"pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
	"prf" => "application/pics-rules",
	"prm" => "application/octet-stream",
	"prx" => "application/octet-stream",
	"ps" => "application/postscript",
	"psd" => "application/octet-stream",
	"psm" => "application/octet-stream",
	"psp" => "application/octet-stream",
	"pub" => "application/x-mspublisher",
	"qt" => "video/quicktime",
	"qtl" => "application/x-quicktimeplayer",
	"qxd" => "application/octet-stream",
	"ra" => "audio/x-pn-realaudio",
	"ram" => "audio/x-pn-realaudio",
	"rar" => "application/octet-stream",
	"ras" => "image/x-cmu-raster",
	"rf" => "image/vnd.rn-realflash",
	"rgb" => "image/x-rgb",
	"rm" => "application/vnd.rn-realmedia",
	"rmi" => "audio/mid",
	"roff" => "application/x-troff",
	"rpm" => "audio/x-pn-realaudio-plugin",
	"rtf" => "application/rtf",
	"rtx" => "text/richtext",
	"scd" => "application/x-msschedule",
	"sct" => "text/scriptlet",
	"sea" => "application/octet-stream",
	"setpay" => "application/set-payment-initiation",
	"setreg" => "application/set-registration-initiation",
	"sgml" => "text/sgml",
	"sh" => "application/x-sh",
	"shar" => "application/x-shar",
	"sit" => "application/x-stuffit",
	"sldm" => "application/vnd.ms-powerpoint.slide.macroEnabled.12",
	"sldx" => "application/vnd.openxmlformats-officedocument.presentationml.slide",
	"smd" => "audio/x-smd",
	"smi" => "application/octet-stream",
	"smx" => "audio/x-smd",
	"smz" => "audio/x-smd",
	"snd" => "audio/basic",
	"snp" => "application/octet-stream",
	"spc" => "application/x-pkcs7-certificates",
	"spl" => "application/futuresplash",
	"spx" => "audio/ogg",
	"src" => "application/x-wais-source",
	"ssm" => "application/streamingmedia",
	"sst" => "application/vnd.ms-pki.certstore",
	"stl" => "application/vnd.ms-pki.stl",
	"sv4cpio" => "application/x-sv4cpio",
	"sv4crc" => "application/x-sv4crc",
	"svg" => "image/svg+xml",
	"svgz" => "image/svg+xml",
	"swf" => "application/x-shockwave-flash",
	"t" => "application/x-troff",
	"tar" => "application/x-tar",
	"tcl" => "application/x-tcl",
	"tex" => "application/x-tex",
	"texi" => "application/x-texinfo",
	"texinfo" => "application/x-texinfo",
	"tgz" => "application/x-compressed",
	"thmx" => "application/vnd.ms-officetheme",
	"thn" => "application/octet-stream",
	"tif" => "image/tiff",
	"tiff" => "image/tiff",
	"toc" => "application/octet-stream",
	"tr" => "application/x-troff",
	"trm" => "application/x-msterminal",
	"ts" => "video/vnd.dlna.mpeg-tts",
	"tsv" => "text/tab-separated-values",
	"ttc" => "application/x-font-ttf",
	"ttf" => "application/x-font-ttf",
	"tts" => "video/vnd.dlna.mpeg-tts",
	"txt" => "text/plain",
	"u32" => "application/octet-stream",
	"uls" => "text/iuls",
	"ustar" => "application/x-ustar",
	"vbs" => "text/vbscript",
	"vcf" => "text/x-vcard",
	"vcs" => "text/plain",
	"vdx" => "application/vnd.ms-visio.viewer",
	"vml" => "text/xml",
	"vsd" => "application/vnd.visio",
	"vss" => "application/vnd.visio",
	"vst" => "application/vnd.visio",
	"vsto" => "application/x-ms-vsto",
	"vsw" => "application/vnd.visio",
	"vsx" => "application/vnd.visio",
	"vtx" => "application/vnd.visio",
	"wav" => "audio/wav",
	"wax" => "audio/x-ms-wax",
	"wbmp" => "image/vnd.wap.wbmp",
	"wcm" => "application/vnd.ms-works",
	"wdb" => "application/vnd.ms-works",
	"webm" => "video/webm",
	"webp" => "image/webp",
	"wks" => "application/vnd.ms-works",
	"wm" => "video/x-ms-wm",
	"wma" => "audio/x-ms-wma",
	"wmd" => "application/x-ms-wmd",
	"wmf" => "application/x-msmetafile",
	"wml" => "text/vnd.wap.wml",
	"wmlc" => "application/vnd.wap.wmlc",
	"wmls" => "text/vnd.wap.wmlscript",
	"wmlsc" => "application/vnd.wap.wmlscriptc",
	"wmp" => "video/x-ms-wmp",
	"wmv" => "video/x-ms-wmv",
	"wmx" => "video/x-ms-wmx",
	"wmz" => "application/x-ms-wmz",
	"woff" => "application/font-woff",
	"woff2" => "application/font-woff2",
	"wps" => "application/vnd.ms-works",
	"wri" => "application/x-mswrite",
	"wrl" => "x-world/x-vrml",
	"wrz" => "x-world/x-vrml",
	"wsdl" => "text/xml",
	"wtv" => "video/x-ms-wtv",
	"wvx" => "video/x-ms-wvx",
	"x" => "application/directx",
	"xaf" => "x-world/x-vrml",
	"xaml" => "application/xaml+xml",
	"xap" => "application/x-silverlight-app",
	"xbap" => "application/x-ms-xbap",
	"xbm" => "image/x-xbitmap",
	"xdr" => "text/plain",
	"xht" => "application/xhtml+xml",
	"xhtml" => "application/xhtml+xml",
	"xla" => "application/vnd.ms-excel",
	"xlam" => "application/vnd.ms-excel.addin.macroEnabled.12",
	"xlc" => "application/vnd.ms-excel",
	"xlm" => "application/vnd.ms-excel",
	"xls" => "application/vnd.ms-excel",
	"xlsb" => "application/vnd.ms-excel.sheet.binary.macroEnabled.12",
	"xlsm" => "application/vnd.ms-excel.sheet.macroEnabled.12",
	"xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
	"xlt" => "application/vnd.ms-excel",
	"xltm" => "application/vnd.ms-excel.template.macroEnabled.12",
	"xltx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.template",
	"xlw" => "application/vnd.ms-excel",
	"xml" => "text/xml",
	"xof" => "x-world/x-vrml",
	"xpm" => "image/x-xpixmap",
	"xps" => "application/vnd.ms-xpsdocument",
	"xsd" => "text/xml",
	"xsf" => "text/xml",
	"xsl" => "text/xml",
	"xslt" => "text/xml",
	"xsn" => "application/octet-stream",
	"xtp" => "application/octet-stream",
	"xwd" => "image/x-xwindowdump",
	"z" => "application/x-compress",
	"zip" => "application/x-zip-compressed"
);

// Boolean html attributes
$EW_BOOLEAN_HTML_ATTRIBUTES = array("checked", "compact", "declare", "defer", "disabled", "ismap", "multiple", "nohref", "noresize", "noshade", "nowrap", "readonly", "selected");

// Use token in URL (reserved, not used, do NOT change!)
define("EW_USE_TOKEN_IN_URL", FALSE, TRUE);

// Use ILIKE for PostgreSql
define("EW_USE_ILIKE_FOR_POSTGRESQL", TRUE, TRUE);

// Use collation for MySQL
define("EW_LIKE_COLLATION_FOR_MYSQL", "", TRUE);

// Use collation for MsSQL
define("EW_LIKE_COLLATION_FOR_MSSQL", "", TRUE);

// Null / Not Null values
define("EW_NULL_VALUE", "##null##", TRUE);
define("EW_NOT_NULL_VALUE", "##notnull##", TRUE);
/**
 * Search multi value option
 * 1 - no multi value
 * 2 - AND all multi values
 * 3 - OR all multi values
*/
define("EW_SEARCH_MULTI_VALUE_OPTION", 3, TRUE);

// Quick search
$EW_BASIC_SEARCH_IGNORE_PATTERN = "/[\?,\.\^\*\(\)\[\]\\\"]/"; // Ignore special characters
define("EW_BASIC_SEARCH_ANY_FIELDS", FALSE, TRUE); // Search "All keywords" in any selected fields

// Validate option
define("EW_CLIENT_VALIDATE", TRUE, TRUE);
define("EW_SERVER_VALIDATE", FALSE, TRUE);

// Blob field byte count for hash value calculation
define("EW_BLOB_FIELD_BYTE_COUNT", 200, TRUE);

// Auto suggest max entries
define("EW_AUTO_SUGGEST_MAX_ENTRIES", 10, TRUE);

// Auto fill original value
define("EW_AUTO_FILL_ORIGINAL_VALUE", false, TRUE);

// Lookup filter value separator
define("EW_LOOKUP_FILTER_VALUE_SEPARATOR", ",", TRUE);

// Checkbox and radio button groups
define("EW_ITEM_TEMPLATE_CLASSNAME", "ewTemplate", TRUE);
define("EW_ITEM_TABLE_CLASSNAME", "ewItemTable", TRUE);

// Page Title Style
define("EW_PAGE_TITLE_STYLE", "Breadcrumbs", TRUE);

// Use responsive layout
$EW_USE_RESPONSIVE_LAYOUT = TRUE;

// Use css flip
$EW_CSS_FLIP = FALSE;
$EW_RTL_LANGUAGES = array("ar", "fa", "he", "iw", "ug", "ur");
/**
 * Locale settings
 * Note: DO NOT CHANGE THE FOLLOWING $EW_* VARIABLES!
 * If you want to use custom settings, customize the locale files for ew_FormatCurrency/Number/Percent functions.
 * Also read http://www.php.net/localeconv for description of the constants
*/
$EW_DECIMAL_POINT = ".";
$EW_THOUSANDS_SEP = ",";
$EW_CURRENCY_SYMBOL = "$";
$EW_MON_DECIMAL_POINT = ".";
$EW_MON_THOUSANDS_SEP = ",";
$EW_POSITIVE_SIGN = "";
$EW_NEGATIVE_SIGN = "-";
$EW_FRAC_DIGITS = 2;
$EW_P_CS_PRECEDES = 1;
$EW_P_SEP_BY_SPACE = 0;
$EW_N_CS_PRECEDES = 1;
$EW_N_SEP_BY_SPACE = 0;
$EW_P_SIGN_POSN = 1;
$EW_N_SIGN_POSN = 1;
$EW_DATE_SEPARATOR = "/";
$EW_TIME_SEPARATOR = ":";
$EW_DATE_FORMAT = "yyyy/mm/dd";
$EW_DATE_FORMAT_ID = 5;
$EW_TIME_ZONE = "GMT";
$EW_LOCALE = array("decimal_point" => &$EW_DECIMAL_POINT,
	"thousands_sep" => &$EW_THOUSANDS_SEP,
	"currency_symbol" => &$EW_CURRENCY_SYMBOL,
	"mon_decimal_point" => &$EW_MON_DECIMAL_POINT,
	"mon_thousands_sep" => &$EW_MON_THOUSANDS_SEP,
	"positive_sign" => &$EW_POSITIVE_SIGN,
	"negative_sign" => &$EW_NEGATIVE_SIGN,
	"frac_digits" => &$EW_FRAC_DIGITS,
	"p_cs_precedes" => &$EW_P_CS_PRECEDES,
	"p_sep_by_space" => &$EW_P_SEP_BY_SPACE,
	"n_cs_precedes" => &$EW_N_CS_PRECEDES,
	"n_sep_by_space" => &$EW_N_SEP_BY_SPACE,
	"p_sign_posn" => &$EW_P_SIGN_POSN,
	"n_sign_posn" => &$EW_N_SIGN_POSN,
	"date_sep" => &$EW_DATE_SEPARATOR,
	"time_sep" => &$EW_TIME_SEPARATOR,
	"date_format" => &$EW_DATE_FORMAT,
	"time_zone" => &$EW_TIME_ZONE
);

// Set default time zone
date_default_timezone_set($EW_TIME_ZONE);

// Cookies
define("EW_COOKIE_EXPIRY_TIME", time() + 365*24*60*60, TRUE); // Change cookie expiry time here

// Client variables
$EW_CLIENT_VAR = array();

//
// Global variables
//

if (!isset($conn)) {

	// Common objects
	$conn = NULL; // Connection
	$Page = NULL; // Page
	$UserTable = NULL; // User table
	$UserTableConn = NULL; // User table connection
	$Table = NULL; // Main table
	$Grid = NULL; // Grid page object
	$Language = NULL; // Language
	$Security = NULL; // Security
	$UserProfile = NULL; // User profile
	$objForm = NULL; // Form

	// Current language
	$gsLanguage = "";

	// Token
	$gsToken = "";

	// Used by ValidateForm/ValidateSearch
	$gsFormError = ""; // Form error message
	$gsSearchError = ""; // Search form error message

	// Used by header.php, export checking
	$gsExport = "";
	$gsExportFile = "";
	$gsCustomExport = "";

	// Used by header.php/footer.php, skip header/footer checking
	$gbSkipHeaderFooter = FALSE;
	$gbOldSkipHeaderFooter = $gbSkipHeaderFooter;

	// Email error message
	$gsEmailErrDesc = "";

	// Debug message
	$gsDebugMsg = "";

	// Debug timer
	$gTimer = NULL;

	// Keep temp images name for PDF export for delete
	$gTmpImages = array();
}

// Mobile detect
$MobileDetect = NULL;

// Breadcrumb
$Breadcrumb = NULL;
?>
<?php

// Menu
define("EW_MENUBAR_ID", "RootMenu", TRUE);
define("EW_MENUBAR_BRAND", "", TRUE);
define("EW_MENUBAR_BRAND_HYPERLINK", "", TRUE);
define("EW_MENUBAR_CLASSNAME", "", TRUE);

//define("EW_MENU_CLASSNAME", "nav nav-list", TRUE);
define("EW_MENU_CLASSNAME", "dropdown-menu", TRUE);
define("EW_SUBMENU_CLASSNAME", "dropdown-menu", TRUE);
define("EW_SUBMENU_DROPDOWN_IMAGE", "", TRUE);
define("EW_SUBMENU_DROPDOWN_ICON_CLASSNAME", "", TRUE);
define("EW_MENU_DIVIDER_CLASSNAME", "divider", TRUE);
define("EW_MENU_ITEM_CLASSNAME", "dropdown-submenu", TRUE);
define("EW_SUBMENU_ITEM_CLASSNAME", "dropdown-submenu", TRUE);
define("EW_MENU_ACTIVE_ITEM_CLASS", "active", TRUE);
define("EW_SUBMENU_ACTIVE_ITEM_CLASS", "active", TRUE);
define("EW_MENU_ROOT_GROUP_TITLE_AS_SUBMENU", FALSE, TRUE);
define("EW_SHOW_RIGHT_MENU", FALSE, TRUE);
?>
<?php
define("EW_PDF_STYLESHEET_FILENAME", "phpcss/ewpdf.css", TRUE); // export PDF CSS styles
define("EW_PDF_MEMORY_LIMIT", "128M", TRUE); // Memory limit
define("EW_PDF_TIME_LIMIT", 120, TRUE); // Time limit
?>
