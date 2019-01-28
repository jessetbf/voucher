<?php
/*
 * PDOCrud - An Advance CRUD application generator.
 * 
 * This page contains all the configuration settings.
 * 
 * By Pritesh Gupta - http://pdocrud.com/
 * 
 * Copyright (C) Pritesh Gupta
 */

/* Configuaration Settings */
global $config;
//script url - Enter complete url inside which script folder is placed
$config["script_url"] = "http://localhost/bfasdb/";
/************************ database ************************/
//Set the host name to connect for database
$config["hostname"] =  "localhost";
//Set the database name
$config["database"] = "blacklig_feralfix";
//Set the username for database access
$config["username"] = "root";
//Set the pwd for the database user
$config["password"] = "Pegasus99";
//Set the database type to be used
$config["dbtype"] = "mysql";
//Please enter purchase code. Please check how to find purchase code details here https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-
$config["purchase_code"] = "5fa46628-c667-4439-aba8-9aaf8b50c5ea";
//Set the character set to be used
$config["characterset"] = "utf8";
//Encryption and Decryption salt
$config["salt"] = "@3dsfsdf**9934324";
/************************crud table settings ************************/
//records to be shown per page
$config["recordsPerPage"] = 10;
//adjacents links
$config["adjacents"] = 1;
//show pagination links (true = show)
$config["pagination"] = true;
//show pagination links (true = show)
$config["recordsPerPageDropdown"] = true;
//show search box (true = show)
$config["searchbox"] = true;
//show delete mulitiple button (true = show)
$config["deleteMultipleBtn"] = true;
//show total records showing (true = show)
$config["totalRecordsInfo"] = true;
//show save button in crud table
$config["savebtn"] = false;
//show add button (true = show)
$config["addbtn"] = true;
//show edit button (true = show)
$config["editbtn"] = true;
//show view button (true = show)
$config["viewbtn"] = true;
//show delete button (true = show)
$config["delbtn"] = true;
//show inline edit button (false = hide)
$config["inlineEditbtn"] = false;
//show clone row (copy row) button (false = hide)
$config["clonebtn"] = false;
//show delete button (true = show)
$config["actionbtn"] = true;
//show sorting button (true = show)
$config["sortable"] = true;
//show export button (true = show)
$config["exportOption"] = true;
//show print button (true = show)
$config["printBtn"] = true;
//show print button (true = show)
$config["csvBtn"] = true;
//show print button (true = show)
$config["excelBtn"] = true;
//show print button (true = show)
$config["pdfBtn"] = true;
//show multi select checkbox column (true = show)
$config["checkboxCol"] = true;
//show number column (true = show)
$config["numberCol"] = true;
//show footer row (true = show)
$config["headerRow"] = true;
//show footer row (true = show)
$config["footerRow"] = true;
//show filters (false = hide)
$config["filter"] = false;
//For dropdown, whether to show "Select" as an option or not
$config["selectOption"] = true;
//whether to show "print" button or not in view page
$config["viewPrintButton"] = true;
//whether to show "back" button or not in view page
$config["viewBackButton"] = true;
//whether to show "delete" button or not in view page
$config["viewDelButton"] = false;
//whether to show "edit" button or not in view page
$config["viewEditButton"] = false;
//Position of the action buttons
$config["actionBtnPosition"] = "right";
//whether to show view form data in tabs or not - added in v 2.6
$config["viewFormTabs"] = false; 
//whether to reset search if search text box is empty - added in v 2.6
$config["resetSearch"] = true;
//Set default search operator  - added in v 2.7
$config["searchOperator"] = "LIKE";
//whether to convert enum field to select dropdown automatically  - added in v 3.1
$config["enumToSelect"] = false;

/******************************** template settings ***********************************/
//Template name to be used. Templates are present in the script/classes/templ
$config["template"] = "bootstrap";
//set skin css to be used (skin css are placed in the script/skin folder)
$config["skin"] = "default";
//default language
$config["lang"] = "en";
/******************************** upload/download folder path ***********************************/
//Upload folder
$config["uploadFolder"] = PDOCrudABSPATH . "uploads/";
//Upload folder URL
$config["uploadURL"] = $config["script_url"] . "script/uploads/";
//download folder
$config["downloadFolder"] = PDOCrudABSPATH . "downloads/";
//Download folder URL
$config["downloadURL"] = $config["script_url"] . "script/downloads/";

/******************************** js config related settings ***********************************/
//date format
$config["dateformat"] = "yy-mm-dd";
//time format
$config["timeformat"] = "HH:mm:ss";
//change month option in datepicker
$config["changeMonth"] = false;
//change year option in datepicker
$config["changeYear"] = false;
//no. of months
$config["numberOfMonths"] = 1;
//show button panel or not
$config["showButtonPanel"] = false;
//set max date
$config["max_date"] = "";
//set min date
$config["min_date"] = "";
/******************************** form related settings  ***********************************/
//block css settings
$config["blockClass"] = array("col-xs-10", "col-sm-10", "col-lg-10");
//block label settings
$config["lableClass"] = array("col-xs-2", "col-sm-2", "col-lg-2");
//hide auto increment field
$config["hideAutoIncrement"] = true;
//hide all lables
$config["hideLable"] = false;
//hide lable of field type html
$config["hideHTMLLable"] = true;
 
/******************************** Load initial js/css/plugins settings  ***********************************/
//load js initially (this js needs to be present in script/js fodler)
$config["loadJs"] = array("jquery.min.js","jquery-ui.min.js","jquery.form.js","jquery-ui-timepicker-addon.js","validator.js","jquery.stepy.js", "popper.min.js");
//load css initially (this css needs to be present in script/css fodler)
$config["loadCss"] = array("style.css","jquery-ui.css","jquery-ui-timepicker-addon.css","font-awesome.min.css");
//recaptcha url
$config["recaptchaurl"] = "https://www.google.com/recaptcha/api.js";
//load plugins initially (list of plugins available)
$config["loadJsPlugins"] = array("chosen");
//display errors directly
$config["displayErrors"] = true;
//By default, whether make form fields required or not
$config["required"] = true;
//whether to trim the value before database insert/update or not
$config["trimField"] = true;
//submit whether using ajax or using simple post
$config["submissionType"] = "ajax";
//enable js validation, if you want to use some plugin for validation set value ="plugin_validator", if you want to use pdocrud validator, 
//set value = "script_validator", if you don't want to use any js validation, set this false.
$config["jsvalidation"] = "plugin_validator";
//enable php validation
$config["phpvalidation"] = true;
/******************************** Other settings  ***********************************/
//show left join data in view of form
$config["leftJoinData"] = false;
//by default single step form
$config["formtype"] = "singlestep";
//whether to encrypt or decrypt fields - version 1.2
$config["encryption"] = true;
//whether to remove js from input data to prevent XSS attack
$config["preventXSS"] = true;
/**************** Email Related Settings ******************/
//whether to use phpemail or smtp. For windows hosting, you need SMTP
$config["emailMode"] = "PHPMAIL";

$config["SMTPHost"] = "ajax";

$config["SMTPPort"] = 25; 

$config["SMTPAuth"] = true;

$config["SMTPusername"] = ""; 

$config["SMTPpassword"] = "";

$config["SMTPSecure"] = ""; 

$config["SMTPKeepAlive"] = true; 
