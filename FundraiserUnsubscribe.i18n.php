<?php
/**
 * Internationalisation file for the FundraiserUnsubscribe extension.
 *
 * @addtogroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'fundraiserunsubscribe-desc' => 'Allows users to unsubscribe from configured fundraising mailing lists',

	'fundraiserunsubscribe' => 'Unsubscribe from Wikimedia Fundraising Email',

	'fundraiserunsubscribe-query' => "Are you sure you want to unsubscribe '''''$1'''''?",
	'fundraiserunsubscribe-info' => 'This will opt you out of emails from the Wikimedia Foundation sent to you as a donor. You may still receive emails to this email address if it is associated with an account on one of our projects. If you have any questions, please contact [mailto:$1 $1].',
	'fundraiserunsubscribe-submit' => 'Unsubscribe',
	'fundraiserunsubscribe-cancel' => 'Cancel',

	'fundraiserunsubscribe-errormsg' => 'An error occurred while attempting to process your request. Please contact [mailto:$1 $1].',

	'fundraiserunsubscribe-success' => 'You have successfully been removed from our mailing list.',
	'fundraiserunsubscribe-sucesswarning' => 'Please allow up to four (4) days for the changes to take effect. We apologize for any emails you receive during this time. If you have any questions, please contact [mailto:$1 $1].',
);

$messages['qqq'] = array(
	'fundraiserunsubscribe-desc' => '{{desc}}',

	'fundraiserunsubscribe' => 'Unsubscribe page title',

	'fundraiserunsubscribe-query' => 'Ask if the user wants to remove email address:$1 from the fundraising mail lists. Leave email as is; a different templating engine is being used.',
	'fundraiserunsubscribe-info' => 'Information on how the unsubscribe request will be processed',
	'fundraiserunsubscribe-submit' => 'Label for button which will unsubscribe them from the fundraising email list.',
	'fundraiserunsubscribe-cancel' => 'Label for button which will cancel the unsubscribe process and redirect them to the WMF homepage',

	'fundraiserunsubscribe-errormsg' => 'Text to display if the unsubscribe failed. Link to email address:$1 for more support.',

	'fundraiserunsubscribe-success' => 'Message indicating that everything that can be done to unsubscribe them has been done.',
	'fundraiserunsubscribe-sucesswarning' => 'Notification to the user that there might be some manual operations or ongoing things that will take time to clear. Will always be shown with fundraiserunsubscribe-success. $1 is an email address for them to contact if they have further questions.',
);

/** British English (British English)
 * @author Shirayuki
 */
$messages['en-gb'] = array(
	'fundraiserunsubscribe-sucesswarning' => 'Please allow up to four (4) days for the changes to take effect. We apologise for any emails you receive during this time. If you have any questions, please contact [mailto:$1 $1].',
);

/** Russian (русский)
 * @author Okras
 */
$messages['ru'] = array(
	'fundraiserunsubscribe-desc' => 'Позволяет пользователям отписаться от списков рассылки, связанных со сбором средств.',
	'fundraiserunsubscribe' => 'Отписаться от писем Фонда Викимедиа, связанных со сбором средств.',
	'fundraiserunsubscribe-query' => "Вы уверены, что хотите исключить '''''$1''''' из рассылки?",
	'fundraiserunsubscribe-info' => 'Это позволит вам отказаться от писем, которые Фонд Викимедиа посылает вам как одному из своих жертвователей. Вы по-прежнему можете получать электронные сообщения на этот адрес электронной почты, если он связан с учётной записью в одном из наших проектов. Если у вас есть какие-либо вопросы, пожалуйста, обратитесь по адресу [mailto:$1 $1].',
	'fundraiserunsubscribe-submit' => 'Отписаться',
	'fundraiserunsubscribe-cancel' => 'Отмена',
	'fundraiserunsubscribe-errormsg' => 'Произошла ошибка при попытке обработать ваш запрос. Пожалуйста, свяжитесь с [mailto:$1 $1].',
	'fundraiserunsubscribe-success' => 'Вы были успешно исключены из нашего списка рассылки.',
	'fundraiserunsubscribe-sucesswarning' => 'Пожалуйста, учтите, что  изменения вступят в силу в течение четырёх (4) дней. Приносим свои извинения за письма, которые вы получите за это время. Если у вас возникли вопросы, обращайтесь по адресу [mailto:$1 $1].',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Qiyue2001
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'fundraiserunsubscribe-desc' => '允许用户退订配置的募捐邮件列表',
	'fundraiserunsubscribe-submit' => '取消订阅',
	'fundraiserunsubscribe-cancel' => '取消',
);
