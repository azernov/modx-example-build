
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*!40000 ALTER TABLE `modx_site_htmlsnippets` DISABLE KEYS */;
REPLACE INTO `modx_site_htmlsnippets` VALUES (2,1,0,'tpl.AjaxForm.example','',0,8,0,'<form action=\"\" method=\"post\" class=\"ajax_form af_example form-horizontal\">\n\n	<div class=\"control-group\">\n		<label class=\"control-label\" for=\"af_name\">[[%af_label_name]]</label>\n		<div class=\"controls\">\n			<input type=\"text\" id=\"af_name\" name=\"name\" value=\"[[+fi.name]]\" placeholder=\"\" class=\"span4\" />\n			<span class=\"error_name\">[[+fi.error.name]]</span>\n		</div>\n	</div>\n\n	<div class=\"control-group\">\n		<label class=\"control-label\" for=\"af_email\">[[%af_label_email]]</label>\n		<div class=\"controls\">\n			<input type=\"email\" id=\"af_email\" name=\"email\" value=\"[[+fi.email]]\" placeholder=\"\" class=\"span4\" />\n			<span class=\"error_email\">[[+fi.error.email]]</span>\n		</div>\n	</div>\n\n	<div class=\"control-group\">\n		<label class=\"control-label\" for=\"af_message\">[[%af_label_message]]</label>\n		<div class=\"controls\">\n			<textarea id=\"af_message\" name=\"message\" class=\"span4\" rows=\"5\">[[+fi.message]]</textarea>\n			<span class=\"error_message\">[[+fi.error.message]]</span>\n		</div>\n	</div>\n\n	<div class=\"control-group\">\n		<div class=\"controls\">\n			<button type=\"reset\" class=\"btn btn-default\">[[%af_reset]]</button>\n			<button type=\"submit\" class=\"btn btn-primary\">[[%af_submit]]</button>\n		</div>\n	</div>\n	\n	[[+fi.success:is=`1`:then=`\n		<div class=\"alert alert-success\">[[+fi.successMessage]]</div>\n	`]]\n	[[+fi.validation_error:is=`1`:then=`\n		<div class=\"alert alert-danger\">[[+fi.validation_error_message]]</div>\n	`]]\n</form>',0,NULL,0,'core/components/ajaxform/elements/chunks/chunk.example.tpl');
REPLACE INTO `modx_site_htmlsnippets` VALUES (45,0,0,'fiDefaultEmailTpl','The default chunk used for the email. Please do not edit this chunk, as this will be overwritten when updating FormIt.',0,1,0,'<p>[[+fields]]</p>',0,'a:0:{}',0,'');
REPLACE INTO `modx_site_htmlsnippets` VALUES (46,0,0,'fiDefaultFiarTpl','The default chunk used for the autoresponder email. Please do not edit this chunk, as this will be overwritten when updating FormIt.',0,1,0,'<p>Hello [[+name]],</p>\n\n<p>Your message has been received. We will respond as soon as possible. Thank you for contacting us.</p>\n\n<p>NOTE: This is an automatic response; please do not respond to this message directly.</p>\n\n<p>Here is your message:<br />\n[[+message:nl2br]]</p>',0,'a:0:{}',0,'');
REPLACE INTO `modx_site_htmlsnippets` VALUES (47,0,0,'fiDefaultOptGroupTpl','The default chunk used by the FormItCountryOptions snippet for the select optgroup. Please do not edit this chunk, as this will be overwritten when updating FormIt.',0,1,0,'<optgroup label=\"[[+text]]\">\n    [[+options]]\n</optgroup>',0,'a:0:{}',0,'');
REPLACE INTO `modx_site_htmlsnippets` VALUES (48,0,0,'fiDefaultOptionTpl','The default chunk used by the FormItCountryOptions snippet for the select option. Please do not edit this chunk, as this will be overwritten when updating FormIt.',0,1,0,'<option value=\"[[+value]]\"[[+selected]]>[[+text]]</option>',0,'a:0:{}',0,'');
/*!40000 ALTER TABLE `modx_site_htmlsnippets` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

