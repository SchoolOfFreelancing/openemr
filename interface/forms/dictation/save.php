<?php
/**
 * dictation save.php
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @copyright Copyright (c) 2019 Brady Miller <brady.g.miller@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */


require_once("../../globals.php");
require_once("$srcdir/api.inc");
require_once("$srcdir/forms.inc");

if (!verifyCsrfToken($_POST["csrf_token_form"])) {
    csrfNotVerified();
}

if ($encounter == "") {
    $encounter = date("Ymd");
}

if ($_GET["mode"] == "new") {
    $newid = formSubmit("form_dictation", $_POST, $_GET["id"], $userauthorized);
    addForm($encounter, "Speech Dictation", $newid, "dictation", $pid, $userauthorized);
} elseif ($_GET["mode"] == "update") {
    sqlInsert("update form_dictation set pid = ?,groupname=?,user=?,authorized=?,activity=1, date = NOW(), dictation=?, additional_notes=? where id=?", array($_SESSION["pid"],$_SESSION["authProvider"],$_SESSION["authUser"],$userauthorized,$_POST["dictation"],$_POST["additional_notes"],$_GET["id"]));
}

$_SESSION["encounter"] = $encounter;
formHeader("Redirecting....");
formJump();
formFooter();
