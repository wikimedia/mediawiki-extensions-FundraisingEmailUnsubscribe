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

/** Message documentation (Message documentation)
 * @author Shirayuki
 */
$messages['qqq'] = array(
	'fundraiserunsubscribe-desc' => '{{desc|name=Fundraiser Unsubscribe|url=http://www.mediawiki.org/wiki/Extension:FundraiserUnsubscribe}}',
	'fundraiserunsubscribe' => 'Unsubscribe page title',
	'fundraiserunsubscribe-query' => 'Ask if the user wants to remove email address:$1 from the fundraising mail lists. Leave email as is; a different templating engine is being used.',
	'fundraiserunsubscribe-info' => 'Unused at this time.

Information on how the unsubscribe request will be processed.

Parameters:
* $1 - email address',
	'fundraiserunsubscribe-submit' => 'Label for button which will unsubscribe them from the fundraising email list.
{{Identical|Unsubscribe}}',
	'fundraiserunsubscribe-cancel' => 'Label for button which will cancel the unsubscribe process and redirect them to the WMF homepage.
{{Identical|Cancel}}',
	'fundraiserunsubscribe-errormsg' => 'Text to display if the unsubscribe failed. Link to email address:$1 for more support.

Parameters:
* $1 - email address',
	'fundraiserunsubscribe-success' => 'Message indicating that everything that can be done to unsubscribe them has been done.',
	'fundraiserunsubscribe-sucesswarning' => 'Notification to the user that there might be some manual operations or ongoing things that will take time to clear. Will always be shown with fundraiserunsubscribe-success. $1 is an email address for them to contact if they have further questions.',
);

/** Bengali (বাংলা)
 * @author Aftab1995
 */
$messages['bn'] = array(
	'fundraiserunsubscribe-cancel' => 'বাতিল',
);

/** Breton (brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'fundraiserunsubscribe-submit' => 'Digoumanantiñ',
	'fundraiserunsubscribe-cancel' => 'Nullañ',
);

/** Czech (česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'fundraiserunsubscribe-desc' => 'Umožňuje uživatelům odhlásit se z nakonfigurovaných e-mailových konferencí k financování',
	'fundraiserunsubscribe' => 'Odhlášení z e-mailů o příspěvcích nadaci Wikimedia',
	'fundraiserunsubscribe-query' => "Jste si jisti, že chcete odhlásit adresu '''''$1'''''?",
	'fundraiserunsubscribe-info' => 'Tímto se odhlásíte z příjmu e-mailů, které vám jako dárci posílala Wikimedia Foundation. I nadále můžete dostávat další e-maily na tuto e-mailovou adresu, pokud je přiřazena k účtu na některém z našich projektů. Pokud máte jakékoli otázky, napište na [mailto:$1 $1].',
	'fundraiserunsubscribe-submit' => 'Odhlásit se',
	'fundraiserunsubscribe-cancel' => 'Storno',
	'fundraiserunsubscribe-errormsg' => 'Při zpracování vašeho požadavku došlo k chybě. Napište prosím na [mailto:$1 $1].',
	'fundraiserunsubscribe-success' => 'Byli jste úspěšně odebráni z naší e-mailové konference.',
	'fundraiserunsubscribe-sucesswarning' => 'Prosíme, abyste nám dali až čtyři (4) dny, než se změny projeví. Omlouváme se za jakékoli e-maily, které v jejich průběhu dostanete. Pokud máte jakékoli dotazy, obraťte se na [mailto:$1 $1].',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'fundraiserunsubscribe-desc' => 'Yn galluogi defnyddwyr i ddad-danysgrifio o restri ebostio i godi arian',
	'fundraiserunsubscribe' => 'Dad-danysgrifio o Ebyst Codi Arian Wikimedia',
	'fundraiserunsubscribe-query' => "Ydych chi wir am ddad-danysgrifio '''''$1'''''?",
	'fundraiserunsubscribe-info' => "Ni fyddwch yn derbyn ebyst oddi wrth Sefydliad Wikimedia yn sgil bod yn gyfrannwr ariannol. Hwyrach y byddwch yn derbyn ebyst i'r cyfeiriad hwn os yw ynghlwm wrth gyfrif ar un o'n prosiectau. Os ydych am holi cwestiwn, cysylltwch â [mailto:$1 $1].",
	'fundraiserunsubscribe-submit' => 'Dad-danysgrifio',
	'fundraiserunsubscribe-cancel' => 'Diddymer',
	'fundraiserunsubscribe-errormsg' => 'Cafwyd gwall wrth geisio eich dad-danysgrifio. Cysylltwch â [mailto:$1 $1].',
	'fundraiserunsubscribe-success' => "Llwyddwyd eich tynnu i ffwrdd o'n rhestr ebostio.",
	'fundraiserunsubscribe-sucesswarning' => 'Gall newidiadau gymryd pedwar (4) diwrnod i ddod i rym. Ymddiheurwn os derbyniwch e-byst yn ystod y cyfnod hwn. Os oes cwestiynau gennych, cysylltwch â [mailto:$1 $1].',
);

/** German (Deutsch)
 * @author Metalhead64
 */
$messages['de'] = array(
	'fundraiserunsubscribe-desc' => 'Ermöglicht es Benutzern, sich aus konfigurierten Mailinglisten zur Spendensammlung auszutragen',
	'fundraiserunsubscribe' => 'E-Mails zur Wikimedia-Spendensammlung abbestellen',
	'fundraiserunsubscribe-query' => "Möchten Sie '''''$1''''' wirklich abbestellen?",
	'fundraiserunsubscribe-info' => 'Diese Aktion meldet Sie vom Empfang von E-Mails der Wikimedia Foundation ab, die Sie als Spender erhalten. Sie könnten weiterhin E-Mails an diese Adresse erhalten, falls diese mit einem unserer Projekte verknüpft ist. Falls Sie Fragen haben, kontaktieren Sie bitte [mailto:$1 $1].',
	'fundraiserunsubscribe-submit' => 'Abbestellen',
	'fundraiserunsubscribe-cancel' => 'Abbrechen',
	'fundraiserunsubscribe-errormsg' => 'Beim Versuch, Ihre Anfrage zu verarbeiten, ist ein Fehler aufgetreten. Bitte senden Sie eine E-Mail an [mailto:$1 $1].',
	'fundraiserunsubscribe-success' => 'Sie wurden erfolgreich aus unserer Mailingliste entfernt.',
	'fundraiserunsubscribe-sucesswarning' => 'Bitte geben Sie uns für die Änderungen vier (4) Tage Zeit. Wir entschuldigen uns für alle E-Mails, die Sie in dieser Zeit erhalten. Falls Sie Fragen haben, kontaktieren Sie bitte [mailto:$1 $1].',
);

/** Spanish (español)
 * @author Fitoschido
 */
$messages['es'] = array(
	'fundraiserunsubscribe-submit' => 'Cancelar la suscripción',
	'fundraiserunsubscribe-cancel' => 'Cancelar',
);

/** French (français)
 * @author Cquoi
 * @author Metroitendo
 * @author Valystant
 */
$messages['fr'] = array(
	'fundraiserunsubscribe-desc' => "Autorise les utilisateurs à se désabonner des listes d'envoi de courriel pour des collectes de fonds.",
	'fundraiserunsubscribe' => 'Se désabonner de Wikimedia Fundraising Email',
	'fundraiserunsubscribe-query' => "Êtes-vous sûr de vouloir vous désabonner de '''''$1''''' ?",
	'fundraiserunsubscribe-info' => 'Cela vous désabonnera des courriels de la Fondation Wikimedia qui vous sont envoyés en tant que donateur. Vous pouvez encore recevoir des courriels à cette adresse si elle reste associée à un compte d’un de nos projets. Si vous avez des questions, veuillez adresser un mél à [mailto:$1 $1].',
	'fundraiserunsubscribe-submit' => 'Se désabonner',
	'fundraiserunsubscribe-cancel' => 'Annuler',
	'fundraiserunsubscribe-errormsg' => "Une erreur s'est produite lors de la tentative de traitement de votre demande. Veuillez contactez [mailto:$1 $1].",
	'fundraiserunsubscribe-success' => 'Vous avez bien été retiré de notre liste de diffusion.',
	'fundraiserunsubscribe-sucesswarning' => 'Veuillez nous accorder quatre (4) jours pour que les modifications deviennent effectives. Nous nous excusons pour tous les courriels que vous pourriez encore recevoir durant ce temps. Si vous avez des questions, veuillez contacter [mailto:$1 $1].',
);

/** Galician (galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'fundraiserunsubscribe-desc' => 'Permite aos usuarios cancelar a subscrición ás listas de correo da recadación de fondos.',
	'fundraiserunsubscribe' => 'Cancelar a subscrición aos correos electrónicos da recadación de fondos da Wikimedia',
	'fundraiserunsubscribe-query' => "Estás seguro de querer cancelar a subscrición de '''''$1'''''?",
	'fundraiserunsubscribe-info' => 'Isto cancelará os correos electrónicos que a Fundación Wikimedia che envía como doante. Poida que sigas recibindo correos se este enderezo está asociado a unha conta nun dos nosos proxectos. Se tes dúbidas ou preguntas, ponte en contacto con nós no enderezo [mailto:$1 $1].',
	'fundraiserunsubscribe-submit' => 'Cancelar a subscrición',
	'fundraiserunsubscribe-cancel' => 'Cancelar',
	'fundraiserunsubscribe-errormsg' => 'Produciuse un erro ao intentar procesar a túa solicitude. Ponte en contacto co enderezo [mailto:$1 $1].',
	'fundraiserunsubscribe-success' => 'Eliminamos correctamente o teu nome da lista de correo.',
	'fundraiserunsubscribe-sucesswarning' => 'Pode levar ata catro (4) días que os cambios se fagan efectivos. Pedimos desculpas polos correos electrónicos que poidas recibir estes días. Se tes algunha pregunta, ponte en contacto con nós no enderezo [mailto:$1 $1].',
);

/** Hebrew (עברית)
 * @author YaronSh
 */
$messages['he'] = array(
	'fundraiserunsubscribe-cancel' => 'ביטול',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'fundraiserunsubscribe-desc' => 'Permitte que usatores se disabona de listas de diffusion pro collecta de fundos',
	'fundraiserunsubscribe' => 'Disabonar se de e-mail de collecta de fundos de Wikimedia',
	'fundraiserunsubscribe-query' => "Es tu secur de voler disabonar te de '''''$1'''''?",
	'fundraiserunsubscribe-info' => 'Isto te disabonara de messages de e-mail ab le Fundation Wikimedia que es inviate a te qua donator. Tu pote continuar a reciper e-mail a iste adresse si illo es associate con un conto sur un de nostre projectos. Si tu ha questiones, per favor contacta [mailto:$1 $1].',
	'fundraiserunsubscribe-submit' => 'Disabonar me',
	'fundraiserunsubscribe-cancel' => 'Cancellar',
	'fundraiserunsubscribe-errormsg' => 'Un error occurreva durante le tentativa de processar tu requesta. Per favor contacta [mailto:$1 $1].',
	'fundraiserunsubscribe-success' => 'Tu ha essite removite de nostre lista de diffusion.',
	'fundraiserunsubscribe-sucesswarning' => 'Per favor permitte usque a quatro (4) dies pro effectuar le cambios. Nos nos excusa pro omne e-mail que tu pote reciper durante iste tempore. Si tu ha questiones, per favor contacta [mailto:$1 $1].',
);

/** Italian (italiano)
 * @author Beta16
 * @author Gianfranco
 */
$messages['it'] = array(
	'fundraiserunsubscribe-desc' => 'Consente agli utenti di cancellarsi dalla mailing list della raccolta fondi',
	'fundraiserunsubscribe' => 'Cancellarsi da Wikimedia Fundraising Email',
	'fundraiserunsubscribe-query' => "Sei sicuro di voler annullare l'iscrizione a '''''$1'''''?",
	'fundraiserunsubscribe-info' => 'Questa operazione ti disiscriverà dal servizio della Wikimedia Foundation con il quale ti sono periodicamente inviate delle e-mail in quanto donatore. Potrai ancora ricevere e-mail a questa casella se è associata a qualche account su uno dei nostri Progetti. Per qualsiasi migliore informazione, scrivi a [mailto:$1 $1].',
	'fundraiserunsubscribe-submit' => "Annulla l'iscrizione",
	'fundraiserunsubscribe-cancel' => 'Annulla',
	'fundraiserunsubscribe-errormsg' => 'Si è verificato un errore durante la lavorazione della tua richiesta. Ti preghiamo di contattarci via email [mailto:$1 $1].',
	'fundraiserunsubscribe-success' => 'Sei stato rimosso dalla nostra mailing list.',
	'fundraiserunsubscribe-sucesswarning' => 'Potresti dover attendere al massimo quattro (4) giorni perché le modifiche abbiano effetto. Ci scusiamo se durante questo periodo dovessi ugualmente ricevere delle email. Per qualsiasi migliore informazione, contattaci a [mailto:$1 $1].',
);

/** Japanese (日本語)
 * @author Shirayuki
 */
$messages['ja'] = array(
	'fundraiserunsubscribe-desc' => '利用者が資金調達メーリングリストを購読解除できるようにする',
	'fundraiserunsubscribe' => 'ウィキメディア資金調達メールの購読解除',
	'fundraiserunsubscribe-query' => "'''''$1''''' を本当に購読解除しますか?",
	'fundraiserunsubscribe-info' => 'ここでは、寄付者のあなたにウィキメディア財団がお送りするメールを購読解除できます。このメールアドレスが、私たちのプロジェクト群のいずれかのアカウントに関連付けられている場合は、引き続きメールが届くかもしれません。何かご質問がある場合は、[mailto:$1 $1] にお問い合わせください。',
	'fundraiserunsubscribe-submit' => '購読解除',
	'fundraiserunsubscribe-cancel' => 'キャンセル',
	'fundraiserunsubscribe-errormsg' => '購読解除の処理でエラーが発生しました。[mailto:$1 $1] にお問い合わせください。',
	'fundraiserunsubscribe-success' => 'メーリングリストを購読解除しました。',
	'fundraiserunsubscribe-sucesswarning' => '変更が反映されるまで最大4日間かかります。それまでにメールが配信されましたら申し訳ありません。何かご質問がある場合は、[mailto:$1 $1] にお問い合わせください。',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'fundraiserunsubscribe-desc' => 'Määd_et möjjelesch, dat es sesch uß däm <i lang="en">e-mail</i>-Verdeiler met de Bäddelbreefe ußdräht.',
	'fundraiserunsubscribe' => 'Bäddelbreefe uß de eije <i lang="en">e-mail</i> ußdraare.',
	'fundraiserunsubscribe-query' => "Wells De verhaftesch de Adräß '''''$1''''' uß dämm Verdeiler ußdraare?",
	'fundraiserunsubscribe-info' => 'Dat heh dräht Ding Addräß uss_em <i lang="en">e-mail</i>-Verdeiler vun de Wikkimeedia Schteftong uß, woh De als ene Schpänder eez ens drop bes. Do künnß emmer noch <i lang="en">e-mails</i> aan di Addräß krijje, wann die med enem Zohjang för ein vun ons Projäkte verbonge es. Wann De noch Froore häs, schriiv_aan: [mailto:$1 $1].',
	'fundraiserunsubscribe-submit' => 'Lohß Jonn!',
	'fundraiserunsubscribe-cancel' => 'Ophüre',
	'fundraiserunsubscribe-errormsg' => 'Ene Fähler es opjetrodde beim Versohch, Desch ußzedraare. Schriiv_aan: [mailto:$1 $1].',
	'fundraiserunsubscribe-success' => 'Do bes jäz nit mieh op onsem <i lang="en">e-mail</i>-Verdeiler.',
	'fundraiserunsubscribe-sucesswarning' => 'Bess_esu_jood_un lohß ons vier Dääsch Zigg, bes Ding Änderonge fäädesch verärbeidt sin. Mer äntscholdijje ons för <i lang="en">e-mails</i>, di De en dä Zigg kreß. Wann De Froore häs, donn ons aan [mailto:$1 $1] schriive.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'fundraiserunsubscribe-desc' => 'Erlaabt et Benotzer sech aus de Mailinglëschte vun de Spendenaktiounen eraushuelen ze loossen',
	'fundraiserunsubscribe' => 'E-Mailen iwwer Wikimedia-Spendenaktiounen ofbestellen',
	'fundraiserunsubscribe-query' => "Sidd dir sécher datt Dir keng Maile vun '''''$1''''' méi kréie wëllt?",
	'fundraiserunsubscribe-submit' => 'Ofbestellen',
	'fundraiserunsubscribe-cancel' => 'Ofbriechen',
	'fundraiserunsubscribe-errormsg' => 'Beim Versuch Är Ufro ze verschaffen ass ee Feeler geschitt. Kontaktéiert w.e.g. [mailto:$1 $1].',
	'fundraiserunsubscribe-success' => 'Dir gouft vun eiser Mailinglëscht erofgeholl.',
	'fundraiserunsubscribe-sucesswarning' => "Gitt eis véier (4) Deeg, bis d'Ännerunge gemaach sinn. Mir entschëllegen eis, wann Dir bis dohin nach E-maile sollt kréien. Wann Dir eng Fro hutt, kontaktéiert w.e.g. [mailto:$1 $1].",
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'fundraiserunsubscribe-desc' => 'Овозможува корисниците да се откажуваат од составените поштенски списоци со молби за дарување на средства.',
	'fundraiserunsubscribe' => 'Откажување од е-пошта за Викимедииното прибирање на средства',
	'fundraiserunsubscribe-query' => "Дали сте сигурни дека сакате да се откажете од претплатата на '''''$1'''''?",
	'fundraiserunsubscribe-info' => 'Со ова одбирате да не добивате е-пошта што ја испраќа Фондацијата Викимедија на дарителите. Адресата и понатаму ќе можете да ја користите за добивање на е-пошта од други корисници ако е здружена со сметка на некој од нашите проекти. Ако имате прашања, обратете се на [mailto:$1 $1].',
	'fundraiserunsubscribe-submit' => 'Откажи претплата',
	'fundraiserunsubscribe-cancel' => 'Откажи',
	'fundraiserunsubscribe-errormsg' => 'Се појави грешка при обидот да ја откажам претплатата. Обратете се на [mailto:$1 $1].',
	'fundraiserunsubscribe-success' => 'Успешно ве отстранив од поштенскиот список.',
	'fundraiserunsubscribe-sucesswarning' => 'Измените ќе стапат на сила во рок од четири (4) дена. Однапред се извинуваме доколку добиете пошта во меѓувреме. Ако имате прашања, обратете се на [mailto:$1 $1].',
);

/** Malayalam (മലയാളം)
 * @author Santhosh.thottingal
 */
$messages['ml'] = array(
	'fundraiserunsubscribe-cancel' => 'റദ്ദാക്കുക',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'fundraiserunsubscribe-desc' => 'Membolehkan pengguna untuk berhenti melanggan senarai mel tabung derma yang dikonfigurasikan.',
	'fundraiserunsubscribe' => 'Berhenti melanggan E-mel Tabung Derma Wikimedia',
	'fundraiserunsubscribe-query' => "Benarkah anda mahu berhenti melanggan '''''$1'''''?",
	'fundraiserunsubscribe-info' => 'Ini akan mengecualikan anda dari e-mel yang dihantar oleh Yayasan Wikimedia kepada anda selaku penderma. Anda masih boleh menerima e-mel ke alamat e-mel ini asalkan ia dikaitkan dengan sebarang akaun pada sebarang projek kami. Jika anda ada sebarang soalan, sila hubungi [mailto:$1 $1].',
	'fundraiserunsubscribe-submit' => 'Berhenti melanggan',
	'fundraiserunsubscribe-cancel' => 'Batalkan',
	'fundraiserunsubscribe-errormsg' => 'Berlakunya ralat ketika cubaan untuk memproses pemohonan anda. Sila hubungi [mailto:$1 $1].',
	'fundraiserunsubscribe-success' => 'Anda telah digugurkan dari senarai mel kami.',
	'fundraiserunsubscribe-sucesswarning' => 'Sila berikan sehingga (4) hari untuk perubahan dilaksanakan. Kami memohon maaf atas sebarang e-mel yang anda terima dalam jangka masa ini. Jika anda ada sebarang soalan, sila hubungi [mailto:$1 $1].',
);

/** Dutch (Nederlands)
 * @author McDutchie
 * @author Siebrand
 */
$messages['nl'] = array(
	'fundraiserunsubscribe-desc' => 'Maakt het mogelijk dat gebruikers zich uitschrijven van ingestelde mailinglijsten voor fondsenwerving',
	'fundraiserunsubscribe' => 'Uitschrijven van e-mails van Wikimedia over fondsenwerving',
	'fundraiserunsubscribe-query' => "Weet u zeker dat u het e-mailadres '''$1''' wilt uitschrijven?",
	'fundraiserunsubscribe-info' => 'Hierdoor ontvangt u niet langer e-mails die Wikimedia aan u als donateur verzendt. Mogelijk ontvangt u nog steeds e-mails op dit e-mailadres als u een gebruiker op een van onze projecten hebt. Als u vragen hebt, neem dan contact op met [mailto:$1 $1].',
	'fundraiserunsubscribe-submit' => 'Uitschrijven',
	'fundraiserunsubscribe-cancel' => 'Annuleren',
	'fundraiserunsubscribe-errormsg' => 'Er is een fout opgetreden tijdens het verwerken van uw verzoek. Neem contact op met [mailto:$1 $1].',
	'fundraiserunsubscribe-success' => 'U bent niet langer ingeschreven op onze mailinglijst.',
	'fundraiserunsubscribe-sucesswarning' => 'Het duurt maximaal vier (4) dagen om deze wijzigingen door te voeren. In het geval u in de tussentijd nog e-mailberichten van ons ontvangt, bieden wij daar bij voorbaat onze excuses voor aan. Neem contact op met [mailto:$1 $1] als u nog vragen hebt.',
);

/** Occitan (occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'fundraiserunsubscribe-desc' => 'Autoriza los utilizaires a se desabonar de las listas de mandadís de corrièr electronic per de collèctas de fonses.',
	'fundraiserunsubscribe' => 'Se desabonar de Wikimedia Fundraising Email',
	'fundraiserunsubscribe-query' => "Sètz segur que vos volètz desabonar de '''''$1''''' ?",
	'fundraiserunsubscribe-submit' => 'Se desabonar',
	'fundraiserunsubscribe-cancel' => 'Anullar',
);

/** Polish (polski)
 * @author Chrumps
 */
$messages['pl'] = array(
	'fundraiserunsubscribe-cancel' => 'Anuluj',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'fundraiserunsubscribe-cancel' => 'ناگارل',
);

/** Portuguese (português)
 * @author Luckas
 */
$messages['pt'] = array(
	'fundraiserunsubscribe-cancel' => 'Cancelar',
);

/** Brazilian Portuguese (português do Brasil)
 * @author Luckas
 */
$messages['pt-br'] = array(
	'fundraiserunsubscribe-cancel' => 'Cancelar',
);

/** Romanian (română)
 * @author Minisarm
 */
$messages['ro'] = array(
	'fundraiserunsubscribe-query' => "Sunteți sigur că doriți să dezabonați adresa '''''$1'''''?",
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'fundraiserunsubscribe-desc' => "Permette a l'utinde de scangellarse da 'a mailing list d'a raccolte de le funne 'mbostate",
	'fundraiserunsubscribe' => 'Scangillate da le Email de Raccolte fonde de Uicchimedia',
	'fundraiserunsubscribe-query' => "Sì secure ca te vuè ccu scangille '''''$1'''''?",
	'fundraiserunsubscribe-info' => "Sta scelte no te face arrevà cchiù email de donatore da Wikimedia Foundation. Tu puè angore avè le email sus a ste indirizze email ce è associate cu 'nu cunde sus a une de le nostre pruggette. Ce tu tìne domande, pe piacere scrive a [mailto:$1 $1].",
	'fundraiserunsubscribe-submit' => 'Scangillate',
	'fundraiserunsubscribe-cancel' => 'Annulle',
	'fundraiserunsubscribe-errormsg' => "Ha assute 'n'errore mendre ste processamme 'a richiesta toje. Pe piacere condatte [mailto:$1 $1].",
	'fundraiserunsubscribe-success' => "E' state luate da 'a mailing list nostre.",
	'fundraiserunsubscribe-sucesswarning' => "Aspitte 'nzigne a quattre (4) sciurne pe fà ca le cangiaminde onne effette. Ne scusame pe ogne email ca tu puè ricevere durande stu tiembe. Ce tu tìne domande, pe piacere condatte [mailto:$1 $1].",
);

/** Swedish (svenska)
 * @author Jopparn
 */
$messages['sv'] = array(
	'fundraiserunsubscribe' => 'Avsluta prenumeration av Wikimedia Fundraising Email',
	'fundraiserunsubscribe-query' => "Är du säker på att du vill avsluta prenumeration för '''''$1'''''?",
	'fundraiserunsubscribe-submit' => 'Avsluta prenumeration',
	'fundraiserunsubscribe-cancel' => 'Avbryt',
	'fundraiserunsubscribe-errormsg' => 'Ett fel uppstod vid försöket att bearbeta din begäran. Vänligen kontakta [mailto:$1 $1].',
	'fundraiserunsubscribe-success' => 'Du har framgångsrikt tagits bort från vår sändlista.',
	'fundraiserunsubscribe-sucesswarning' => 'Det kan ta upp till fyra (4) dagar för att ändringarna ska börja gälla. Vi ber om ursäkt för alla e-postmeddelanden som du får under denna tid. Om du har några frågor, vänligen kontakta [mailto:$1 $1].',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'fundraiserunsubscribe-submit' => 'చందావిరమించు',
	'fundraiserunsubscribe-cancel' => 'రద్దుచేయి',
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

/** Urdu (اردو)
 * @author Noor2020
 */
$messages['ur'] = array(
	'fundraiserunsubscribe-desc' => 'صارفین مجاز ہیں تشکیل شدہ عطیات کے برقی خط کی جانکاری سے رکنیت ختم کرنے میں ۔',
	'fundraiserunsubscribe-query' => "کیا آپ رکنیت ختم کرنا چاہتے ہیں ' ' $1 ' '؟",
	'fundraiserunsubscribe-cancel' => 'منسوخ',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'fundraiserunsubscribe-desc' => '允许用户退订配置的募捐邮件列表',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Simon Shek
 */
$messages['zh-hant'] = array(
	'fundraiserunsubscribe-desc' => '允許用者從籌款郵寄名單中取消訂閱。',
	'fundraiserunsubscribe' => '取消訂閱維基媒體籌款電子郵件',
	'fundraiserunsubscribe-query' => "您確認要取消訂閱'''''$1'''''嗎？",
	'fundraiserunsubscribe-info' => '這會取消訂閱維基媒體基金會與捐款者有關的郵件。若您任何維基媒體項目用戶，您仍然會收到有關的電郵。如有任何疑問，請聯絡[mailto:$1 $1]。',
	'fundraiserunsubscribe-submit' => '取消訂閱',
	'fundraiserunsubscribe-cancel' => '取消',
	'fundraiserunsubscribe-errormsg' => '處理請求時出錯。請聯絡[mailto:$1 $1]。',
	'fundraiserunsubscribe-success' => '您的電郵已從我們的電郵清單中移除。',
	'fundraiserunsubscribe-sucesswarning' => '您的更改將於四天內生效。在其間若收到任何籌款電郵，我們謹此致歉。如有任何疑問，請聯絡[mailto:$1 $1]。',
);
