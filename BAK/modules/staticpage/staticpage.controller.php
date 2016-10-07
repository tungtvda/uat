<?php
class StaticPage extends BaseController
{
	protected $controller_name = "staticpage";

	protected function Start()
	{
		$model = new StaticPageModel();
		return $model;
	}

	protected function Contact()
	{
		$start = $this->Start();
		$this->ReturnView($start->Contact(), true);
	}

	protected function PageNotFound()
	{
		$start = $this->Start();
		$this->ReturnView($start->PageNotFound(), true);
	}

    protected function JavascriptDisabled()
	{
		$start = $this->Start();
		$this->ReturnView($start->JavascriptDisabled(), true);
	}

    protected function SystemNotFound()
	{
		$start = $this->Start();
		$this->ReturnView($start->SystemNotFound(), true);
	}

    protected function TestDNS()
    {
        $start = $this->Start();
        $param = $start->TestDNS();
    }

	protected function ContactProcess()
	{
	    if ($_POST['SQ']=="")
        {
            exit();
        }

	    // Validate Genuine Form Submission
        CRUD::validateFormSubmit('1', 'ContactFormPost', NULL, $param['config']['SITE_DIR']."/contact");

	    // Honey Pot Captcha
        CRUD::validateFormSubmit('', 'HPot', TRUE);

		$start = $this->Start();
		$param = $start->ContactProcess();
		#echo "<pre>"; print_r($param); echo "</pre>";

		$_SESSION['main']['staticpage_contact'] = $param['status'];

        if ($param['status']['ok']=="1")
        {
    		$mailer = new BaseMailer();

    		$mailer->From = $param['config']['EMAIL_SENDER'];
    		$mailer->AddReplyTo($param['form_param']['Email'], $param['form_param']['Name']);
    		$mailer->FromName = $param['form_param']['Name'];

    		$mailer->Subject = '['.$param['config']['SITE_NAME'].'] You have a message from '.$param['form_param']['Name'];

     		$mailer->AddAddress($param['config']['CONTACT_EMAIL_TO'], '');
            $mailer->AddAddress($param['config']['CONTACT_EMAIL_CC1'], '');
            $mailer->AddAddress($param['config']['CONTACT_EMAIL_CC2'], '');
            $mailer->AddAddress($param['config']['CONTACT_EMAIL_CC3'], '');
            $mailer->AddAddress($param['config']['CONTACT_EMAIL_CC4'], '');
            $mailer->AddAddress($param['config']['CONTACT_EMAIL_CC5'], '');
            $mailer->AddAddress($param['config']['CONTACT_EMAIL_CC6'], '');
            $mailer->AddAddress($param['config']['CONTACT_EMAIL_CC7'], '');
            $mailer->AddAddress($param['config']['CONTACT_EMAIL_CC8'], '');
            $mailer->AddAddress($param['config']['CONTACT_EMAIL_CC9'], '');
            $mailer->AddAddress($param['config']['CONTACT_EMAIL_CC10'], '');
    		#$mailer->AddCC('user@domain.com', 'User');
    		#$mailer->AddBCC('abc@gmail.com', '');
    		#$mailer->ConfirmReadingTo = 'user@domain.com';

    		ob_start();
    		require_once('modules/staticpage/mail/main.contactprocess.php');
    		$htmlBody = ob_get_contents();
    		ob_end_clean();

    		ob_start();
    		require_once('modules/staticpage/mail/main.contactprocess.txt.php');
    		$txtBody = ob_get_contents();
    		ob_end_clean();

    		$mailer->IsHTML(true);
    		$mailer->Body = $htmlBody;
    		$mailer->AltBody = $txtBody;

    		$mailer->Send();

    		$mailer->ClearAddresses();
    		$mailer->ClearAttachments();

            Helper::redirect($param['config']['SITE_DIR']."/contact");
        }
        else
        {
            Helper::redirect($param['config']['SITE_DIR']."/contact");
        }
	}
}
?>