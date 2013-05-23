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

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'fundraiserunsubscribe-cancel' => 'Annulle',
);

/** Ukrainian (українська)
 * @author Ата
 */
$messages['uk'] = array(
	'fundraiserunsubscribe-desc' => 'Дозволяє користувачам відписатися від налаштованих списків розсилки по збору коштів',
	'fundraiserunsubscribe' => 'Відписатися від Wikimedia Fundraising Email',
	'fundraiserunsubscribe-query' => "Ви впевнені, що хочете відписатись '''''$1'''''?",
	'fundraiserunsubscribe-info' => "Це дозволить Вам відмовитися від листів, які Фонд Вікімедіа надсилає Вам, як одному зі своїх жертводавців. Ви все ще можете отримувати електронні повідомлення на цю адресу електронної пошти, якщо вона пов'язана з обліковим записом в одному з наших проектів. Якщо у Вас є які-небудь питання, будь ласка, зверніться за адресою [mailto:$1 $1].",
	'fundraiserunsubscribe-submit' => 'Відписатися',
	'fundraiserunsubscribe-cancel' => 'Скасувати',
	'fundraiserunsubscribe-errormsg' => "Під час обробки Вашого запиту сталася помилка. Будь ласка, зв'яжіться з [mailto:$1 $1].",
	'fundraiserunsubscribe-success' => 'Вас успішно вилучено з нашого списку розсилки',
	'fundraiserunsubscribe-sucesswarning' => 'Будь ласка, врахуйте, що зміни наберуть силу протягом чотирьох (4) днів. Ми приносимо вибачення за будь-які листи, які Ви отримаєте за цей час. Якщо у Вас виникли питання, будь ласка, звертайтеся за адресою [mailto:$1 $1].',
);
