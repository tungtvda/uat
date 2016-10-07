<?php
class TranslationModel extends BaseModel
{
	private $output = array();
        //private $module = array();
        private $module_name = "Translation";
	private $module_dir = "modules/translation/";
        private $module_default_url = "/main/translation/index";
        private $module_default_admin_url = "/admin/translation/index";
        private $module_default_member_url = "/member/translation/index";

	public function __construct()
	{
		parent::__construct();

        /*$this->module['translation'] = array(
        'name' => "Translation",
        'dir' => "modules/translation/",
        'default_url' => "/main/translation/index",
        'admin_url' => "/admin/translation/index");*/
	}
        
        public function APITranslated()
    {
        // Initiate REST API class
        $restapi = new RestAPI();

        // Get method
        $method = $restapi->getMethod();

        if ($method=="GET")
        {
            
            // Get all request data
            $request_data = $restapi->getRequestData();
            
            $result = array();
                
                if($request_data['LanguageCode'] == 'en')
                {    
                
                $dataSet = array('member-breadcrumb-home' => "Home",
                    'member-guide-promotion-next' => "T&C",
                    'member-guide-promotion-no-display-message' => "No promotion at the moment",
                    'member-live-chat' => "Live Chat",
                    'member-website' => "Website",
                    'member-guide-promotion-setting-message' => "If you want to skip promotion after login, please change your setting by go to setting menu",
                    'member-guide-promotion-setting' => "Promotion",
                    'member-guide-promotion-slide' => "T&C",
                    'member-profile-personal-details' => "Personal Details",
                    'member-profile-bank-details' => "Bank Details",
                    'member-register-unmatch' => "New Password and Confirm Password did not match",
                    'member-login-agentid' => "Agent ID",
                    'member-header-required' => "Please fill all required field",
                    'member-deposit-rules' => "Please agree to the term and rule by tick the checkbox",
                    'member-forgotpassword-contactus' => "contact us",
                    'member-history-time-elapse' => "Time Elapse",
                    'member-history-lastweek' => "Last Week",
                    'member-breadcrumb-login' => "Login",
                    'member-breadcrumb-member' => "Member",
                    'member-breadcrumb-transaction' => "Transactions",
                    'member-breadcrumb-wallet' => "Wallet",
                    'member-dashboard-changepassword' => "Change Password",
                    'member-dashboard-deposit' => "Deposit",
                    'member-dashboard-manage-title' => "Manage My Account",
                    'member-dashboard-managemytransactions' => "Manage My Transactions",
                    'member-dashboard-message' => "Welcome to your dashboard! Here you can view and manage all aspects of your account.",
                    'member-dashboard-profile' => "My Profile",
                    'member-dashboard-title' => "Dashboard",
                    'member-dashboard-transactionhistory' => "Transaction History",
                    'member-dashboard-transfer' => "Transfer",
                    'member-dashboard-wallet' => "Wallet",
                    'member-dashboard-withdrawal' => "Withdrawal",
                    'member-deposit-amount' => "Amount",
                    'member-deposit-atmdeposit' => "ATM Deposit",
                    'member-deposit-bankinslip' => "Submit Bank Slip Through",
                    'member-deposit-cancel' => "Cancel",
                    'member-deposit-channel' => "Deposit Channel",
                    'member-deposit-cimb' => "CIMB",
                    'member-deposit-ctmcashdepositmachine' => "CTM Cash Deposit Machine",
                    'member-deposit-datetime' => "Date/Time of Deposit",
                    'member-deposit-depositbank' => "Deposit Bank",
                    'member-deposit-details' => "Deposit Details",
                    'member-deposit-fastprocessnote' => "For fast processing, please select your choice of bank slip submit to us as below",
                    'member-deposit-hongleong' => "HongLeong",
                    'member-deposit-internetbanking' => "Internet Banking",
                    'member-deposit-maybank' => "MayBank",
                    'member-deposit-none' => "None",
                    'member-deposit-promotion' => "Promotion:",
                    'member-deposit-publicbank' => "PublicBank",
                    'member-deposit-referenceno' => "Reference No (SEQ)",
                    'member-deposit-rule' => "I already understand the rules and Deposit Promo Rules if any",
                    'member-deposit-selectone' => "Please select one",
                    'member-deposit-submit' => "Submit",
                    'member-deposit-title' => "Deposit",
                    'member-deposit-transfer' => "Transfer",
                    'member-email-register' => "website",
                    'member-forgotpassword-email' => "Email",
                    'member-forgotpassword-error' => "The username and email do not match. Please try again.",
                    'member-forgotpassword-message-1' => "Please enter your username below and submit to retrieve a new password. If you have also lost your username or registered email, please contact us for further assistance",
                    'member-forgotpassword-submit' => "Submit",
                    'member-forgotpassword-title' => "Forgot Password",
                    'member-forgotpassword-title-breadcrumb' => "Forgot Password?",
                    'member-forgotpassword-username' => "Username",
                    'member-header-wallet-balance' => "Main Wallet Balance",
                    'member-header-welcome' => "Welcome",
                    'member-history-allstatuses' => "All Statuses",
                    'member-history-alltypes' => "All Types",
                    'member-history-amount' => "Amount (MYR)",
                    'member-history-bankin' => "Thank you. Your transaction has been requested successfully and is under processing. The amount will be banked in to your designated bank account within 10 minutes.",
                    'member-history-bonus' => "Bonus (MYR)",
                    'member-history-commission' => "Commission (MYR)",
                    'member-history-credited' => "Thank you. Your transaction has been requested successfully and is under processing. Your funds are currently being verified and will be credited to your account within 5 - 10 minutes.",
                    'member-history-datefrom' => "Date (From)",
                    'member-history-dateposted' => "Date Posted",
                    'member-history-dateto' => "Date (To)",
                    'member-history-deposit' => "For cash deposit, please visit our live chat to confirm your deposit.",
                    'member-history-depositchannel' => "Deposit Channel: ",
                    'member-history-details' => "Details",
                    'member-history-error' => "Transaction error occurred.",
                    'member-history-nav' => "History",
                    'member-history-norecord' => "No records.",
                    'member-history-notavailable' => "N/A",
                    'member-history-referencecode' => "Reference Code:",
                    'member-history-rejectedremark' => "Rejected Remark:",
                    'member-history-remark' => "Remark",
                    'member-history-reset' => "Reset",
                    'member-history-search' => "Search",
                    'member-history-search-message' => "Submitting this search form without any data entry will show all results. Clicking on the Reset button will also remove all filters and show all results.",
                    'member-history-showhide' => "click to show/hide",
                    'member-history-status' => "Status",
                    'member-history-thisweek' => "This week",
                    'member-history-title' => "My Transactions",
                    'member-history-totalresults' => "Total Results: ",
                    'member-history-totalresults' => "Total Results: ",
                    'member-history-transfer' => "Thank you. Your transaction has been requested successfully and is under processing. Your funds are currently being verified and will be transferred within 5 - 10 minutes.",
                    'member-history-type' => "Type",
                    'member-history-week' => "Week",
                    'member-login-activation-message' => "Registration is complete! You may now login below.",
                    'member-login-email-generated' => "A new password has been generated and sent to your registered email.",
                    'member-login-forgotpassword' => "Forgot your password?",
                    'member-login-loggedout-message' => "You have logged out successfully.",
                    'member-login-login' => "Login",
                    'member-login-password' => "Password:",
                    'member-login-passwordsaved-message' => "Your new password has been saved. Please login again to continue.",
                    'member-login-title' => "MEMBER LOGIN",
                    'member-login-username' => "Username:",
                    'member-login-username-invalid' => "The username and/or password entered is invalid. Please try again.",
                    'member-logout' => "Log Out",
                    'member-mail-forgotpassword-hi' => "Hi",
                    'member-mail-forgotpassword-message-1' => "We have received your request for a new password:",
                    'member-mail-forgotpassword-message-2' => "To protect your account, please login to your account immediately at your register live game website and change your password. Thank you.",
                    'member-mail-forgotpassword-message-3' => "Best Regards,",
                    'member-mail-forgotpassword-password' => "Password:",
                    'member-mail-forgotpassword-username' => "Username:",
                    'member-mail-register-agent-messg-1' => "New Member",
                    'member-mail-register-agent-messg-2' => "Member Name",
                    'member-mail-register-agent-messg-3' => "Member Username",
                    'member-mail-register-agent-messg-4' => "Please visit your",
                    'member-mail-register-hi' => "Hi",
                    'member-mail-register-message-1' => "Congratulations on your new account! You are all set to get the best of what",
                    'member-mail-register-message-2' => "can offer.",
                    'member-mail-register-message-3' => "To access your account, please visit our",
                    'member-mail-register-message-4' => "Bonus:",
                    'member-mail-register-message-5' => "None",
                    'member-mail-register-message-6' => "Best Regards,",
                    'member-mail-register-username' => "Username:",
                    'member-mail-transaction' => "To access your account, please visit",
                    'member-mobilesms-activation-1' => "Please enter your activation code.",
                    'member-mobilesms-activation-2' => " It is sent to ",
                    'member-mobilesms-activationcode' => "SMS Activation Code:",
                    'member-mobilesms-activationcode-requested' => "You have recently requested for the activation code. Please wait for at least one minute to request for another code.",
                    'member-mobilesms-error' => "The SMS activation code entered is invalid. Please try again.",
                    'member-mobilesms-refresh' => "Click here to refresh page",
                    'member-mobilesms-resend-activationcode' => "Resend Activation Code:",
                    'member-mobilesms-resent' => "Your SMS code has been resent successfully.",
                    'member-mobilesms-send' => "Send",
                    'member-mobilesms-submit' => "Submit",
                    'member-mobilesms-title' => "Activation",
                    'member-mobilesms-update' => "Update",
                    'member-mobilesms-update-message' => "If you have not receive your code, you may click resend or insert a new mobile number",
                    'member-mobilesms-update-note' => "(If you entered a wrong mobile number and want to update your mobile number for a resend of activation code. Including country code, e.g. 60192255667)",
                    'member-mobilesms-update-number' => "Update Mobile Number:",
                    'member-mobilesms-updated' => "Updated your mobile number successfully.",
                    'member-password-confirmnewpassword' => "Confirm New Password",
                    'member-password-current' => "Current Password",
                    'member-password-currentpassword' => "Current Password",
                    'member-password-error' => "Current password entered is incorrect. Please try again.",
                    'member-password-newpassword' => "New Password",
                    'member-password-prompt' => "To protect your account, please enter a new password.",
                    'member-password-submit' => "Submit",
                    'member-password-title' => "Change Password",
                    'member-profile-bank' => "Bank",
                    'member-profile-bankaccountno' => "Bank Account No",
                    'member-profile-company' => "Company",
                    'member-profile-dateofbirth' => "Date of Birth",
                    'member-profile-email' => "Email",
                    'member-profile-facebookID' => "Facebook ID",
                    'member-profile-faxno' => "Fax No",
                    'member-profile-fullname' => "Full Name",
                    'member-profile-gender' => "Gender",
                    'member-profile-mobileno' => "Mobile No",
                    'member-profile-mobileno-sms' => "(Including country code, e.g. 60192255667. Compulsory for SMS verification)",
                    'member-profile-nationality' => "Nationality",
                    'member-profile-nric' => "NRIC",
                    'member-profile-nric-1' => "The NRIC number ",
                    'member-profile-nric-2' => "exists in our records. Each member can only register once. Please try again with another NRIC number.",
                    'member-profile-passport' => "Passport",
                    'member-profile-passport-1' => "The Passport number ",
                    'member-profile-passport-2' => "exists in our records. Each member can only register once. Please try again with another Passport number.",
                    'member-profile-phoneno' => "Phone No",
                    'member-profile-secondarybank' => "Secondary Bank",
                    'member-profile-secondarybankaccountno' => "Secondary Bank Account No",
                    'member-profile-title' => "My Profile",
                    'member-profile-update' => "Update",
                    'member-profile-updated' => "Profile updated successfully.",
                    'member-profile-username' => "Username",
                    'member-profile-username-note' => "(Your login username)",
                    'member-register-agree-1' => "I agree that the information provided above is accurate, and I accept the",
                    'member-register-agree-2' => "terms of use",
                    'member-register-agree-3' => "of the website.",
                    'member-register-bank' => "Bank Name",
                    'member-register-bankaccountno' => "Bank Account No",
                    'member-register-bankaccountno-note' => "(Bank Account must be real for future smooth withdrawal)",
                    'member-register-confirmpassword' => "Confirm Password",
                    'member-register-email' => "Email",
                    'member-register-facebookID' => "Facebook ID",
                    'member-register-fullname' => "Full Name",
                    'member-register-fullname-note' => "The name must match with your bank account name for withdrawal.",
                    'member-register-login-note' => "(You will use this to login)",
                    'member-register-message' => "Creating your account with us is easy! Start by filling up form below:",
                    'member-register-mobileno' => "Mobile No",
                    'member-register-mobileno-note' => "(Including country code, e.g. 60192255667. Compulsory for SMS verification)",
                    'member-register-newpassword' => "New Password",
                    'member-register-nric-1' => "The NRIC number ",
                    'member-register-nric-2' => " exists in our records. Each member can only register once. Please try again with another NRIC number. ",
                    'member-register-passport-1' => "The Passport number",
                    'member-register-passport-2' => "exists in our records. Each member can only register once. Please try again with another Passport number.",
                    'member-register-passportno' => "Passport No",
                    'member-register-security' => "The Security Question is answered incorrectly. Please try again.",
                    'member-register-securityquestion' => "Security Question",
                    'member-register-submit' => "Submit",
                    'member-register-title' => "Register",
                    'member-register-username' => "Username",
                    'member-register-username-1' => "The username ",
                    'member-register-username-2' => "is taken. Please try again with another username.",
                    'member-side-information' => "Get first-hand news on our latest events",
                    'member-side-member' => "Be a Member",
                    'member-side-order' => "Keep track of your orders",
                    'member-side-register' => "Register with us and start enjoy the following benefits:",
                    'member-transfer-amount' => "Amount (MYR)",
                    'member-transfer-balance' => "Balance:",
                    'member-transfer-cancel' => "Cancel",
                    'member-transfer-from' => "Transfer From",
                    'member-transfer-message' => "The amount specified is less than the available balance in the selected wallet. Please try again.",
                    'member-transfer-minimum-amount' => "(Minimum MYR 10.00)",
                    'member-transfer-save' => "Save",
                    'member-transfer-title' => "Transfer",
                    'member-transfer-to' => "Transfer To",
                    'member-wallet-link' => "Link",
                    'member-wallet-main' => "Main Wallet",
                    'member-wallet-nav' => "Wallet",
                    'member-wallet-norecord' => "No records.",
                    'member-wallet-notavailable' => "-",
                    'member-wallet-password' => "Password",
                    'member-wallet-pinnumber' => "Pin Number",
                    'member-wallet-play' => "Play Now",
                    'member-wallet-processing' => "-",
                    'member-wallet-product' => "Product",
                    'member-wallet-title' => "Wallets",
                    'member-wallet-username' => "Username",
                    'member-withdrawal-amount' => "Amount (MYR)",
                    'member-withdrawal-balance' => "Balance (MYR)",
                    'member-withdrawal-bank' => "Bank",
                    'member-withdrawal-bankaccountno' => "Bank Account No",
                    'member-withdrawal-cancel' => "Cancel",
                    'member-withdrawal-fullname' => "Full Name",
                    'member-withdrawal-secondarybank' => "Secondary Bank",
                    'member-withdrawal-secondarybankaccountno' => "Bank Account No",
                    'member-withdrawal-submit' => "Submit",
                    'member-withdrawal-title' => "Withdrawal",
                );
                }
                  
                 if($request_data['LanguageCode'] == 'ms')
                {    
                    
                 $dataSet = array('member-breadcrumb-home' => "Laman Utama",
                        'member-guide-promotion-no-display-message' => "Tiada promosi pada masa ini",
                        'member-guide-promotion-next' => "T&S",
                        'member-live-chat' => "Bersembang Secara Langsung",
                        'member-website' => "Laman Web",
                        'member-guide-promotion-setting-message' => "Jika anda hendak melangkau promosi selepas log masuk, sila tukar tetapan anda dengan pergi ke menu tetapan",
                        'member-guide-promotion-setting' => "Promosi",
                        'member-guide-promotion-slide' => "T&C",
                        'member-profile-personal-details' => "Maklumat Peribadi",
                        'member-profile-bank-details' => "Maklumat Bank",
                        'member-register-unmatch' => "Kata Laluan Baru dan Sahkan Kata Laluan tidak sepadan",
                        'member-header-required' => "Sila isi semua bidang yang diperlukan",
                        'member-deposit-rules' => "Sila bersetuju dengan syarat dan peraturan dengan tandakan kotak semak",
                        'member-login-agentid' => "Ejen ID",
                        'member-history-time-elapse' => "Selang Waktu",
                        'member-history-depositchannel' => "Deposit Channel: ",
                        'member-history-referencecode' => "Kod Rujukan:",
                        'member-history-norecord' => "Tiada rekod.",
                     	'member-history-bonus' => "Bonus (MYR)",
                        'member-history-lastweek' => "Minggu Lepas",
                        'member-breadcrumb-login' => "Log masuk",
                        'member-breadcrumb-member' => "ahli",
                        'member-breadcrumb-transaction' => "Transaksi",
                        'member-breadcrumb-wallet' => "Dompet",
                        'member-dashboard-changepassword' => "Tukar Kata Laluan",
                        'member-dashboard-deposit' => "Deposit",
                        'member-dashboard-manage-title' => "Akaun Saya",
                        'member-dashboard-managemytransactions' => "Transaksi Saya",
                        'member-dashboard-message' => "Selamat datang ke LAMAN WEB kami ! Di sini anda boleh menguruskan semua aspek akaun anda.",
                        'member-dashboard-profile' => "Profil Saya",
                        'member-dashboard-title' => "Halaman Utama",
                        'member-dashboard-transactionhistory' => "Maklumat Transaksi",
                        'member-dashboard-transfer' => "Pemindahan",
                        'member-dashboard-wallet' => "Dompet",
                        'member-dashboard-withdrawal' => "Pengeluaran",
                        'member-deposit-amount' => "Jumlah",
                        'member-deposit-atmdeposit' => "ATM Deposit",
                        'member-deposit-bankinslip' => "Hantar Bank Slip Melalui",
                        'member-deposit-cancel' => "Batal",
                        'member-deposit-channel' => "Saluran deposit",
                        'member-deposit-cimb' => "CIMB",
                        'member-deposit-ctmcashdepositmachine' => "CTM Mesin Deposit Tunai",
                        'member-deposit-datetime' => "Tarikh / Waktu Deposit",
                        'member-deposit-depositbank' => "Deposit Bank",
                        'member-deposit-details' => "Butiran deposit",
                        'member-deposit-fastprocessnote' => "Untuk pemprosesan segera, sila anda pilih pilihan slip bank serahkan kepada kami seperti di bawah",
                        'member-deposit-hongleong' => "HongLeong",
                        'member-deposit-internetbanking' => "Perbankan Internet",
                        'member-deposit-maybank' => "MayBank",
                        'member-deposit-none' => "Tiada",
                        'member-deposit-promotion' => "Promosi:",
                        'member-deposit-publicbank' => "PublicBank",
                        'member-deposit-referenceno' => "Nombor rujukan (SEQ)",
                        'member-deposit-rule' => "Saya sudah memahami peraturan dan Kaedah-Kaedah Promosi Deposit jika ada.",
                        'member-deposit-selectone' => "Silakan pilih salah satu",
                        'member-deposit-submit' => "Hantar",
                        'member-deposit-title' => "Deposit",
                        'member-deposit-transfer' => "Pemindahan",
                        'member-email-register' => "laman web",
                        'member-forgotpassword-contactus' => "hubungi kami",
                        'member-forgotpassword-email' => "Emel",
                        'member-forgotpassword-error' => "Nama pengguna dan e-mel tidak sepadan. Sila cuba sekali lagi.",
                        'member-forgotpassword-message-1' => "Sila masukkan nama pengguna anda di bawah dan hantar untuk mendapatkan kata laluan baru. Juga jika anda mempunyai kehilangan nama pengguna anda atau e-mel berdaftar, sila hubungi kami untuk dapatkan bantuan lanjut",
                        'member-forgotpassword-message-2' => "untuk bantuan lanjut.",
                        'member-forgotpassword-submit' => "Hantar",
                        'member-forgotpassword-title' => "Lupa Kata Laluan",
                        'member-forgotpassword-title-breadcrumb' => "Lupa Kata Laluan?",
                        'member-forgotpassword-username' => "Nama Pengguna",
                        'member-header-wallet-balance' => "Baki Dompet Utama",
                        'member-header-welcome' => "Selamat Datang",
                        'member-history-allstatuses' => "Semua status",
                        'member-history-alltypes' => "Semua Jenis",
                        'member-history-amount' => "Jumlah (MYR)",
                        'member-history-bankin' => "Terima kasih . Transaksi anda telah berjaya diminta dan adalah di bawah pemprosesan . Jumlah ini akan dimasukkan ke dalam akaun bank anda dalam masa 10 minit .",
                        'member-history-commission' => "Komisen (MYR)",
                        'member-history-credited' => "Terima kasih . Transaksi anda telah berjaya diminta dan adalah di bawah pemprosesan . Dana anda sedang disahkan dan akan dikreditkan ke akaun anda dalam masa 5 - 10 minit .",
                        'member-history-datefrom' => "Tarikh (Dari)",
                        'member-history-dateposted' => "Tarikh dihantar",
                        'member-history-dateto' => "Tarikh (Hingga)",
                        'member-history-deposit' => "Untuk deposit tunai , sila (chat secara langsung) dengan kami untuk mengesahkan deposit anda .",
                        'member-history-details' => "butiran",
                        'member-history-error' => "Kesilapan transaksi berlaku .",
                        'member-history-nav' => "Maklumat Transaksi",
                        'member-history-remark' => "Catatan",
                        'member-history-reset' => "Reset",
                        'member-history-search' => "Carian",
                        'member-history-search-message' => "Mengemukakan borang carian ini tanpa apa-apa catatan data akan menunjukkan semua keputusan . Klik pada butang Reset juga akan mengeluarkan semua penapis dan menunjukkan semua keputusan .",
                        'member-history-showhide' => "klik untuk menunjukkan/ sembunyikan",
                        'member-history-status' => "Status",
                        'member-history-thisweek' => "Minggu ini",
                        'member-history-title' => "Transaksi saya",
                        'member-history-totalresults' => "Jumlah Keputusan:",
                        'member-history-transfer' => "Terima kasih . Transaksi anda telah berjaya diminta dan adalah di bawah pemprosesan . Dana anda sedang disahkan dan akan dipindahkan dalam masa 5 - 10 minit .",
                        'member-history-type' => "Jenis",
                        'member-history-week' => "Minggu",
                        'member-login-activation-message' => "Pendaftaran selesai ! Anda kini boleh login.",
                        'member-login-email-generated' => "Kata laluan baru telah dijana dan dihantar ke e-mel berdaftar anda ",
                        'member-login-forgotpassword' => "Lupa kata laluan anda?",
                        'member-login-loggedout-message' => "Anda telah berjaya log keluar.",
                        'member-login-login' => "Log masuk",
                        'member-login-password' => "Kata laluan :",
                        'member-login-passwordsaved-message' => "Kata laluan baru anda telah disimpan . Sila log masuk sekali lagi untuk meneruskan.",
                        'member-login-title' => "AHLI LOG MASUK",
                        'member-login-username' => "Nama pengguna :",
                        'member-login-username-invalid' => "Nama pengguna dan / atau kata laluan yang dimasukkan adalah tidak sah. Sila cuba sekali lagi .",
                        'member-logout' => "Log Keluar",
                        'member-mail-forgotpassword-hi' => "Hai",
                        'member-mail-forgotpassword-message-1' => "Kami telah menerima permintaan Anda untuk mendapatkan kata laluan baru :",
                        'member-mail-forgotpassword-message-2' => "Untuk melindungi akaun Anda, Sila log masuk ke laman web permainan yang anda daftar dan tukar Kata Laluan dengan serta merta. Terima kasih.",
                        'member-mail-forgotpassword-message-3' => "Salam Hormat,",
                        'member-mail-forgotpassword-password' => "Kata laluan:",
                        'member-mail-forgotpassword-username' => "Nama pengguna:",
                        'member-mail-register-agent-messg-1' => "Ahli Baru",
                        'member-mail-register-agent-messg-2' => "Nama Ahli",
                        'member-mail-register-agent-messg-3' => "Nama Pengguna",
                        'member-mail-register-agent-messg-4' => "Sila lawati",
                        'member-mail-register-hi' => "Hai",
                        'member-mail-register-message-1' => "Tahniah atas akaun baru anda ! Kami bersedia untuk memberikan perkhidmatan yang terbaik daripada ",
                        'member-mail-register-message-2' => "yang kami tawarkan.",
                        'member-mail-register-message-3' => "Untuk mengakses akaun anda, sila lawati kami di ",
                        'member-mail-register-message-4' => "Bonus:",
                        'member-mail-register-message-5' => "Tiada",
                        'member-mail-register-message-6' => "Salam Hormat,",
                        'member-mail-register-username' => "Nama pengguna:",
                        'member-mail-transaction' => "Untuk mengakses akaun anda, sila lawati ",
                        'member-mobilesms-activation-1' => "Sila masukkan kod pengaktifan.",
                        'member-mobilesms-activation-2' => "Ia dihantar ke",
                        'member-mobilesms-activationcode' => "SMS Kod Pengaktifan :",
                        'member-mobilesms-activationcode-requested' => "Anda telah baru-baru ini meminta kod pengaktifan. Sila tunggu sekurang-kurangnya satu minit untuk meminta kod lain.",
                        'member-mobilesms-error' => "Kod pengaktifan SMS tidak sah . Sila cuba sekali lagi .",
                        'member-mobilesms-refresh' => "Klik di sini untuk muat semula halaman",
                        'member-mobilesms-resend-activationcode' => "Hantar semula Kod Pengaktifan :",
                        'member-mobilesms-resent' => "Kod SMS anda telah  berjaya dihantar semula .",
                        'member-mobilesms-send' => "Hantar",
                        'member-mobilesms-submit' => "Hantar",
                        'member-mobilesms-title' => "Pengaktifan",
                        'member-mobilesms-update' => "Kemaskini",
                        'member-mobilesms-update-message' => "Jika anda tidak menerima sms kod pengaktifan, anda boleh klik hantar semula atau memasukkan nombor telefon bimbit baru",
                        'member-mobilesms-update-note' => "( Jika anda masukkan nombor telefon bimbit salah dan ingin mengemas kini nombor telefon bimbit anda untuk penghantaran semula kod pengaktifan . Masukkan kod negara , contohnya 60192255667 )",
                        'member-mobilesms-update-number' => "Kemaskini Nombor Telefon Bimbit :",
                        'member-mobilesms-updated' => " Berjaya dikemaskini nombor telefon bimbit anda .",
                        'member-password-confirmnewpassword' => "Sahkan Kata Laluan Baru",
                        'member-password-current' => "Kata laluan semasa",
                        'member-password-currentpassword' => "Kata laluan semasa",
                        'member-password-error' => "Kata laluan yang dimasukkan adalah salah. Sila cuba sekali lagi .",
                        'member-password-newpassword' => "Kata laluan baru",
                        'member-password-prompt' => "Untuk melindungi akaun anda, sila masukkan kata laluan baru.",
                        'member-password-submit' => "Hantar",
                        'member-password-title' => "Tukar Kata Laluan",
                        'member-profile-bank' => "Bank",
                        'member-profile-bankaccountno' => "Nombor Akaun Bank",
                        'member-profile-company' => "Syarikat",
                        'member-profile-dateofbirth' => "Tarikh Lahir",
                        'member-profile-email' => "E-mel",
                        'member-profile-facebookID' => "Facebook ID",
                        'member-profile-faxno' => "Nombor Faks",
                        'member-profile-fullname' => "Nama Penuh",
                        'member-profile-gender' => "Jantina",
                        'member-profile-mobileno' => "Nombor Telefon Bimbit",
                        'member-profile-mobileno-sms' => "( masukkan kod negara , misalnya 60192255667. Wajib untuk verifikasi SMS )",
                        'member-profile-nationality' => "Warganegara",
                        'member-profile-nric' => "Kad Pengenalan",
                        'member-profile-nric-1' => "Nombor kad pengenalan",
                        'member-profile-nric-2' => "wujud dalam rekod kami . Setiap ahli hanya boleh mendaftar sekali . Sila cuba lagi dengan nombor kad pengenalan lain.",
                        'member-profile-passport' => "Pasport",
                        'member-profile-passport-1' => "Nombor Pasport",
                        'member-profile-passport-2' => "wujud dalam rekod kami . Setiap ahli hanya boleh mendaftar sekali . Sila cuba lagi dengan nombor Pasport lain.",
                        'member-profile-phoneno' => "Nombor Telefon",
                        'member-profile-secondarybank' => "Bank Kedua",
                        'member-profile-secondarybankaccountno' => "Nombor Akaun Bank Kedua",
                        'member-profile-title' => "Profil Saya",
                        'member-profile-update' => "memperbarui",
                        'member-profile-updated' => "Profil berjaya dikemas kini .",
                        'member-profile-username' => "Nama pengguna",
                        'member-profile-username-note' => "( Nama pengguna log masuk anda )",
                        'member-register-agree-1' => "Saya bersetuju bahawa maklumat yang diberikan di atas adalah tepat, dan saya menerima",
                        'member-register-agree-2' => "syarat-syarat penggunaan",
                        'member-register-agree-3' => "dari laman web.",
                        'member-register-bank' => "Bank",
                        'member-register-bankaccountno' => "Nombor Akaun Bank",
                        'member-register-bankaccountno-note' => "(Akaun bank mestilah akaun benar untuk wang pengeluaran lancar di masa hadapan)",
                        'member-register-confirmpassword' => "Sahkan Kata Laluan",
                        'member-register-email' => "E-mel",
                        'member-register-facebookID' => "Facebook ID",
                        'member-register-fullname' => "Nama Penuh",
                        'member-register-fullname-note' => "Nama ini mesti sepadan dengan nama akaun bank anda untuk pengeluaran.",
                        'member-register-login-note' => "(Anda akan menggunakan ini untuk log masuk)",
                        'member-register-message' => "Mencipta akaun anda dengan kami adalah mudah ! Mulakan dengan mengisi borang di bawah:",
                        'member-register-mobileno' => "Nombor Telefon Bimbit",
                        'member-register-mobileno-note' => "(Termasuk kod negara , contohnya 60192255667. Wajib untuk pengesahan SMS )",
                        'member-register-newpassword' => "Kata laluan baru",
                        'member-register-nric-1' => "Nombor kad pengenalan",
                        'member-register-nric-2' => "wujud dalam rekod kami . Setiap ahli hanya boleh mendaftar sekali . Sila cuba lagi dengan nombor kad pengenalan lain.",
                        'member-register-passport-1' => "Nombor Pasport",
                        'member-register-passport-2' => "wujud dalam rekod kami . Setiap ahli hanya boleh mendaftar sekali . Sila cuba lagi dengan nombor Pasport lain.",
                        'member-register-passportno' => "Nombor pasport",
                        'member-register-security' => "Soalan Keselamatan tidak dijawab dengan betul. Sila cuba sekali lagi .",
                        'member-register-securityquestion' => "Soalan Keselamatan",
                        'member-register-submit' => "Hantar",
                        'member-register-title' => "Pendaftaran",
                        'member-register-username' => "Nama pengguna",
                        'member-register-username-1' => "Nama pengguna",
                        'member-register-username-2' => "telah diambil. Sila cuba lagi dengan nama pengguna lain.",
                        'member-side-information' => "Dapatkan berita terkini dari acara yang terbaru",
                        'member-side-member' => "Menjadi Ahli",
                        'member-side-order' => "Jejaki pesanan anda",
                        'member-side-register' => "Daftar dengan kami dan mula menikmati faedah-faedah berikut :",
                        'member-transfer-amount' => "Jumlah (MYR)",
                        'member-transfer-balance' => "Baki Kira-kira:",
                        'member-transfer-cancel' => "Batal",
                        'member-transfer-from' => "Pindahan Daripada",
                        'member-transfer-message' => "Jumlah yang dinyatakan adalah kurang daripada baki yang ada dalam dompet yang dipilih . Sila cuba sekali lagi .",
                        'member-transfer-minimum-amount' => "(Minima MYR 10.00)",
                        'member-transfer-save' => "Simpan",
                        'member-transfer-title' => "Pemindahan",
                        'member-transfer-to' => "Pindahan Ke",
                        'member-wallet-assword' => "Kata laluan",
                        'member-wallet-link' => "Pautan",
                        'member-wallet-main' => "Dompet Utama",
                        'member-wallet-nav' => "Dompet",
                        'member-wallet-norecord' => "Tiada rekod .",
                        'member-wallet-notavailable' => "-",
                        'member-wallet-password' => "Kata laluan",
                        'member-wallet-pinnumber' => "Nombor Pin",
                        'member-wallet-play' => "Main Sekarang",
                        'member-wallet-processing' => "-",
                        'member-wallet-product' => "Produk",
                        'member-wallet-title' => "Dompet",
                        'member-wallet-username' => "Nama pengguna",
                        'member-withdrawal-amount' => "Jumlah (MYR)",
                        'member-withdrawal-balance' => "Baki (MYR)",
                        'member-withdrawal-bank' => "Bank",
                        'member-withdrawal-bankaccountno' => "Nombor Akaun Bank",
                        'member-withdrawal-cancel' => "Batal",
                        'member-withdrawal-fullname' => "Nama Penuh",
                        'member-withdrawal-secondarybank' => "Bank Kedua",
                        'member-withdrawal-secondarybankaccountno' => "Nombor Akaun Bank",
                        'member-withdrawal-submit' => "Hantar",
                        'member-withdrawal-title' => "Pengeluaran",
                    );  
                } 
                
                
                if($request_data['LanguageCode'] == 'zh_CN')
                {    
                    
                  $dataSet = array('member-breadcrumb-home' => "首页",
                                    'member-guide-promotion-no-display-message' => "目前没有推销",
                                    'member-live-chat' => "在线聊天",
                                    'member-website' => "网站",
                                    'member-guide-promotion-next' => "规则与条例",
                                    'member-guide-promotion-setting-message' => "如果您想在登录后跳过推销信息，请去改变你的设置在设置菜单",
                                    'member-guide-promotion-setting' => "推销",
                                    'member-guide-promotion-slide' => "推销滑动",
                                    'member-profile-personal-details' => "个人资料",
                                    'member-profile-bank-details' => "银行资料",
                                    'member-register-unmatch' => "新密码和确认密码不配",
                                    'member-header-required' => "请填写所有必填表格",
                                    'member-deposit-rules' => "请同意条件和规则，并且勾选选框",
                                    'member-login-agentid' => "代理人ID",
                                    'member-history-time-elapse' => "时间流逝",
                                    'member-history-norecord' => "没有记录",
                                    'member-history-referencecode' => "参考代码:",
                                    'member-history-depositchannel' => "存款频道:", 
                                    'member-history-lastweek' => "上星期",
                                    'member-breadcrumb-login' => "登入",
                                    'member-breadcrumb-member' => "用户",
                                    'member-breadcrumb-transaction' => "交易",
                                    'member-breadcrumb-wallet' => "钱包",
                                    'member-dashboard-changepassword' => "更改密码",
                                    'member-dashboard-deposit' => "存款",
                                    'member-dashboard-manage-title' => "管理我的帐户",
                                    'member-dashboard-managemytransactions' => "管理我的交易",
                                    'member-dashboard-message' => "欢迎来到您的主版 ！在这里您可以查看和管理您所有的帐户。",
                                    'member-dashboard-profile' => "个人资料",
                                    'member-dashboard-title' => "主版",
                                    'member-dashboard-transactionhistory' => "交易记录",
                                    'member-dashboard-transfer' => "转账",
                                    'member-dashboard-wallet' => "钱包 ",
                                    'member-dashboard-withdrawal' => "提款",
                                    'member-deposit-amount' => "金额",
                                    'member-deposit-atmdeposit' => "ATM存款",
                                    'member-deposit-bankinslip' => "提交银行单通过",
                                    'member-deposit-cancel' => "取消",
                                    'member-deposit-channel' => "存款通道 ",
                                    'member-deposit-cimb' => "CIMB",
                                    'member-deposit-ctmcashdepositmachine' => "CTM 现金存款机",
                                    'member-deposit-datetime' => "存款的日期/时间",
                                    'member-deposit-depositbank' => "银行存款",
                                    'member-deposit-details' => "存款资料",
                                    'member-deposit-fastprocessnote' => "对于快速处理，请选择您要的银行发票提交给我们如下",
                                    'member-deposit-hongleong' => "HongLeong",
                                    'member-deposit-internetbanking' => "网上银行",
                                    'member-deposit-maybank' => "MayBank",
                                    'member-deposit-none' => "无",
                                    'member-deposit-promotion' => "促销:",
                                    'member-deposit-publicbank' => "PublicBank",
                                    'member-deposit-referenceno' => "参考编号 Bank slip: Reference Number (SEQ)",
                                    'member-deposit-rule' => "我已经理解了规则和存款促销规则,如果任何 ",
                                    'member-deposit-selectone' => "请选择一个",
                                    'member-deposit-submit' => "提交",
                                    'member-deposit-title' => "存款",
                                    'member-deposit-transfer' => "转让",
                                    'member-email-register' => "网站",
                                    'member-forgotpassword-contactus' => "联络我们",
                                    'member-forgotpassword-email' => "电子邮件",
                                    'member-forgotpassword-error' => "用户名和电子邮件不配. 请再试一次.",
                                    'member-forgotpassword-message-1' => "请在下面输入您的用户名和提交以便一个新的密码。如果你也失去了您的用户名或注册的电子邮件，请联系我们寻求进一步的帮助",
                                    'member-forgotpassword-message-2' => "使让我们进一步协助.",
                                    'member-forgotpassword-submit' => "提交",
                                    'member-forgotpassword-title' => "忘记密码",
                                    'member-forgotpassword-title-breadcrumb' => "忘记密码?",
                                    'member-forgotpassword-username' => "用户名",
                                    'member-header-wallet-balance' => "主要钱包余额 ",
                                    'member-header-welcome' => "欢迎",
                                    'member-history-allstatuses' => "所有状态 ",
                                    'member-history-alltypes' => "所有类型",
                                    'member-history-amount' => "金额 （MYR）",
                                    'member-history-bankin' => "谢谢。您的交易已成功申请并正在处理。在10分钟内，该金额将存入到您指定的银行账户。",
                                    'member-history-bonus' => "奖金 (MYR)",
                                    'member-history-commission' => "佣金 (MYR)",
                                    'member-history-credited' => "谢谢。您的交易已成功申请并正在处理。您的金额目前正在核实中，并在5-10分钟内转账到您的帐户内。",
                                    'member-history-datefrom' => "日期 （从）",
                                    'member-history-dateposted' => "发布日期 ",
                                    'member-history-dateto' => "日期（到）",
                                    'member-history-deposit' => "关于现金存款,请联络在线客户，我们会为您确认的存款。 ",
                                    'member-history-details' => "资料",
                                    'member-history-error' => "发生交易错误。",
                                    'member-history-nav' => "记录",
                                    'member-history-remark' => "备注",
                                    'member-history-reset' => "重置",
                                    'member-history-search' => "搜索",
                                    'member-history-search-message' => "提交此搜索没有任何数据条目将显示所有结果。点击重置按钮也会删除所有筛选器和显示所有结果。",
                                    'member-history-showhide' => "点击此处，显示 / 隐藏",
                                    'member-history-status' => "状态 ",
                                    'member-history-thisweek' => "这星期",
                                    'member-history-title' => "我的交易",
                                    'member-history-totalresults' => "总结",
                                    'member-history-transfer' => " 谢谢。您的交易已成功申请并正在处理。您的金额目前正在核实中，并在5-10分钟内转账。",
                                    'member-history-type' => "类型",
                                    'member-history-week' => "星期",
                                    'member-login-activation-message' => "注册已完成! 现在您可以登录。 ",
                                    'member-login-email-generated' => "新密码已发送到您注册的电子邮件。",
                                    'member-login-forgotpassword' => "忘记密码?",
                                    'member-login-loggedout-message' => "您已经成功退出。",
                                    'member-login-login' => "登入",
                                    'member-login-password' => "密码：",
                                    'member-login-passwordsaved-message' => "您的新密码已保存。 请重新登录后继续。 ",
                                    'member-login-title' => "用户登入",
                                    'member-login-username' => "用户名：",
                                    'member-login-username-invalid' => "你输入的用户名和/或密码不正确。请再试一次",
                                    'member-logout' => "退出",
                                    'member-mail-forgotpassword-hi' => "您好",
                                    'member-mail-forgotpassword-message-1' => "我们已收到您申请新密码的要求：",
                                    'member-mail-forgotpassword-message-2' => "为了保护您的帐户，请在您的注册现场游戏网站立即登录到您的帐户，并更改密码。谢谢。",
                                    'member-mail-forgotpassword-message-3' => "此致敬意，",
                                    'member-mail-forgotpassword-password' => "密码:",
                                    'member-mail-forgotpassword-username' => "用户名：",
                                    'member-mail-register-agent-messg-1' => "新成员",
                                    'member-mail-register-agent-messg-2' => "成员姓名",
                                    'member-mail-register-agent-messg-3' => "成员用户名",
                                    'member-mail-register-agent-messg-4' => "请浏览你",
                                    'member-mail-register-hi' => "您好",
                                    'member-mail-register-message-1' => " 恭喜您的新帐户！您的所有设置以获得最佳的",
                                    'member-mail-register-message-2' => " 的优惠。",
                                    'member-mail-register-message-3' => "若要登入您的帐户，请游览我们的",
                                    'member-mail-register-message-4' => "奖金：",
                                    'member-mail-register-message-5' => "无",
                                    'member-mail-register-message-6' => "此致敬意，",
                                    'member-mail-register-username' => "用户名：",
                                    'member-mail-transaction' => "若要登入您的帐户，请游览",
                                    'member-mobilesms-activation-1' => "请输入您的启动代码。",
                                    'member-mobilesms-activation-2' => "已发送到",
                                    'member-mobilesms-activationcode' => "短信启动代码: ",
                                    'member-mobilesms-activationcode-requested' => "你已申请启动代码。请等待至少一分钟，申请另一组启动代码。",
                                    'member-mobilesms-error' => "输入短信激活代码无效。请再试一次。",
                                    'member-mobilesms-refresh' => "在此点击刷新页面 ",
                                    'member-mobilesms-resend-activationcode' => "重新发送启动代码: ",
                                    'member-mobilesms-resent' => "您的短信代码已重新发送成功。 ",
                                    'member-mobilesms-send' => "发送",
                                    'member-mobilesms-submit' => "提交",
                                    'member-mobilesms-title' => "启动",
                                    'member-mobilesms-update' => "更新",
                                    'member-mobilesms-update-message' => "如果您没有收到启动代码,您可以点击重新发送或输入一个新的手机号码 ",
                                    'member-mobilesms-update-note' => " （如果你输入了错误的手机号码，并希望更新您的手机号码为启动号码重新发送。请输入包括国家代码，如60192255667）",
                                    'member-mobilesms-update-number' => "更新手机号码: ",
                                    'member-mobilesms-updated' => "您的手机号码已成功更新。",
                                    'member-password-confirmnewpassword' => "确认新密码 ",
                                    'member-password-current' => "现有密码",
                                    'member-password-currentpassword' => "现有密码",
                                    'member-password-error' => "密码不正确。 请再试一次。 ",
                                    'member-password-newpassword' => "新密码 ",
                                    'member-password-prompt' => "为了保护您的帐户，请输入新密",
                                    'member-password-submit' => "提交",
                                    'member-password-title' => "更改密码",
                                    'member-profile-bank' => "银行",
                                    'member-profile-bankaccountno' => "银行账户号码",
                                    'member-profile-company' => "公司",
                                    'member-profile-dateofbirth' => "生日日期",
                                    'member-profile-email' => "电邮信箱",
                                    'member-profile-facebookID' => "Facebook ID",
                                    'member-profile-faxno' => "传真号码",
                                    'member-profile-fullname' => "全名",
                                    'member-profile-gender' => "性别",
                                    'member-profile-mobileno' => "手机号码",
                                    'member-profile-mobileno-sms' => "（包括国家代码，例如60192255667.强制短信验证）",
                                    'member-profile-nationality' => "国籍",
                                    'member-profile-nric' => "身份证号码",
                                    'member-profile-nric-1' => "身份证号码",
                                    'member-profile-nric-2' => "已存在于我们的记录。每个成员只能注册一次。请使用另一个身份证号码再试。",
                                    'member-profile-passport' => "护照",
                                    'member-profile-passport-1' => "护照号码",
                                    'member-profile-passport-2' => "已存在于我们的记录。每个成员只能注册一次。请使用另一个护照号码再试。",
                                    'member-profile-phoneno' => "电话号码",
                                    'member-profile-secondarybank' => "银行2",
                                    'member-profile-secondarybankaccountno' => "银行2账户号码",
                                    'member-profile-title' => "个人资料",
                                    'member-profile-update' => "更新",
                                    'member-profile-updated' => "个人资料更新成功。",
                                    'member-profile-username' => "用户名",
                                    'member-profile-username-note' => "（你的登录用户名）",
                                    'member-register-agree-1' => "我同意上面所提供的信息是准确的,我接受",
                                    'member-register-agree-2' => "使用条件",
                                    'member-register-agree-3' => "该网站。",
                                    'member-register-bank' => "银行",
                                    'member-register-bankaccountno' => "银行账户号码",
                                    'member-register-bankaccountno-note' => "(银行账户必须是真的方便未来顺利取钱)",
                                    'member-register-confirmpassword' => "确认密码",
                                    'member-register-email' => "电子邮件",
                                    'member-register-facebookID' => "Facebook ID",
                                    'member-register-fullname' => "全名",
                                    'member-register-fullname-note' => "姓名必须与您的银行帐户名称相配",
                                    'member-register-login-note' => "(您将使用此登录) ",
                                    'member-register-message' => "非常容易的注册你的帐户！ 现在就填满以下表格：",
                                    'member-register-mobileno' => "手机号码",
                                    'member-register-mobileno-note' => "（包括国家代码，例如60192255667.强制短信验证）",
                                    'member-register-newpassword' => "新密码",
                                    'member-register-nric-1' => "身份证号码",
                                    'member-register-nric-2' => "已存在于我们的记录。每个成员只能注册一次。请用另一个身份证号码再试。",
                                    'member-register-passport-1' => "护照号码",
                                    'member-register-passport-2' => "已存在于我们的记录。每个成员只能注册一次。请使用另一个护照号码再试。",
                                    'member-register-passportno' => "护照号码",
                                    'member-register-security' => "安全问题回答错误。请再试一次。",
                                    'member-register-securityquestion' => "安全问题",
                                    'member-register-submit' => "提交",
                                    'member-register-title' => "注册",
                                    'member-register-username' => "用户名",
                                    'member-register-username-1' => "用户名",
                                    'member-register-username-2' => "已被使用,请使用其他用户名字再试一次。",
                                    'member-side-information' => "获取我们的第一手最新新闻",
                                    'member-side-member' => "成为会员",
                                    'member-side-order' => "跟进您的订单 ",
                                    'member-side-register' => "与我们注册，并开始享受以下优惠",
                                    'member-transfer-amount' => "金额 （MYR）",
                                    'member-transfer-balance' => "余额",
                                    'member-transfer-cancel' => "取消",
                                    'member-transfer-from' => "转账从",
                                    'member-transfer-message' => "指定的数量小于选定的钱包的可用余额。请再试一次。",
                                    'member-transfer-minimum-amount' => "（最低 MYR 10.00）",
                                    'member-transfer-save' => "保存",
                                    'member-transfer-title' => "转账",
                                    'member-transfer-to' => "转账去",
                                    'member-wallet-link' => "链接",
                                    'member-wallet-main' => "主要钱包",
                                    'member-wallet-nav' => "钱包",
                                    'member-wallet-norecord' => "没有记录",
                                    'member-wallet-notavailable' => "-",
                                    'member-wallet-password' => "密码",
                                    'member-wallet-pinnumber' => "验证号码",
                                    'member-wallet-play' => "进入游戏",
                                    'member-wallet-processing' => "-",
                                    'member-wallet-product' => "产品",
                                    'member-wallet-title' => "钱包",
                                    'member-wallet-username' => "用户名",
                                    'member-withdrawal-amount' => "金额 （MYR）",
                                    'member-withdrawal-balance' => "余额 (MYR)",
                                    'member-withdrawal-bank' => "银行",
                                    'member-withdrawal-bankaccountno' => "银行账户号码",
                                    'member-withdrawal-cancel' => "取消",
                                    'member-withdrawal-fullname' => "全名",
                                    'member-withdrawal-secondarybank' => "银行2",
                                    'member-withdrawal-secondarybankaccountno' => "银行账户号码",
                                    'member-withdrawal-submit' => "提交",
                                    'member-withdrawal-title' => "提款",
                                    ); 
                }
                                                                             
                
                array_push($result, $dataSet);
                $output['content'] = $result;
                $output['count'] = count($output['content']);              
                
                // Set output
            if ($output['count']>0)
            {
                $result = json_encode($output);
                $restapi->setResponse('200', 'OK', $result);
            }
            else
            {
                $restapi->setResponse('404', 'Resource Not Found');
            }
        }
        else
        {
            $restapi->setResponse('405', 'HTTP Method Not Accepted');
        }
                
    }

	public function Index($param)
	{
		$crud = new CRUD();

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM translation WHERE 1 = 1";
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/main/translation/index';
		$limit = 5;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM translation WHERE 1 = 1 ORDER BY LanguageCode ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'LanguageCode' => $row['LanguageCode'],
			'Section' => $row['Section'],
			'OriginalText' => $row['OriginalText'],
			'TranslatedText' => $row['TranslatedText']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['translation']['name'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Translations", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['translation']['dir'].'inc/main/index.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
		'meta' => array('custom_meta' => "on", 'custom_meta_loc' => $this->module['translation']['dir'].'meta/main/index.inc.php'));

		return $this->output;
	}

	public function View($param)
	{
		$sql = "SELECT * FROM translation WHERE ID = '".$param."' AND 1 = 1";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'LanguageCode' => $row['LanguageCode'],
			'Section' => $row['Section'],
			'OriginalText' => $row['OriginalText'],
			'TranslatedText' => $row['TranslatedText']);

			$i += 1;
		}

        // Set breadcrumb
        $breadcrumb = array(
            array("Title" => $this->module['translation']['name'], "Link" => $this->module['translation']['default_url']),
            array("Title" => $result[0]['Title'], "Link" => "")
        );

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => $result[0]['Title'], 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module['translation']['dir'].'inc/main/view.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($breadcrumb, $this->config),
		'content' => $result,
		'content_param' => array('count' => $i),
		'meta' => array('custom_meta' => "on", 'custom_meta_loc' => $this->module['translation']['dir'].'meta/main/view.inc.php'));

		return $this->output;
	}
        
        
        public function ChangeLanguage($param)
	{       
                if($param=='zhCN')
                {
                    $param = 'zh_CN';
                }    
            
                //$_SESSION['language'] = "$param";
                //$_SESSION['language'] = "en";
                
                /*if($_SERVER['REMOTE_ADDR']=='1.9.124.44')
                {
                 echo $_SERVER['HTTP_REFERER'];
                 exit;
                }*/
                // Set breadcrumb
                $breadcrumb = array(
                    array("Title" => $this->module['translation']['name'], "Link" => $this->module['translation']['default_url']),
                    array("Title" => $result[0]['Title'], "Link" => "")
                );

		$this->output = array(
                'config' => $this->config,
                //'page' => array('title' => "News", 'template' => 'common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/main/index.inc.php'),
                'content' => $_SERVER['HTTP_REFERER'],
                'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate),
                'secure' => NULL,
                'meta' => array('active' => "on"));

                return $this->output;

	}

	public function AdminIndex($param)
	{
		// Initialise query conditions
		$query_condition = "";

		$crud = new CRUD();

		if ($_POST['Trigger']=='search_form')
		{
			// Reset Query Variable
			$_SESSION['translation_'.__FUNCTION__] = "";

			$query_condition .= $crud->queryCondition("LanguageCode",$_POST['LanguageCode'],"LIKE");
			$query_condition .= $crud->queryCondition("Section",$_POST['Section'],"LIKE");
			$query_condition .= $crud->queryCondition("OriginalText",$_POST['OriginalText'],"LIKE");
			$query_condition .= $crud->queryCondition("TranslatedText",$_POST['TranslatedText'],"LIKE");

			$_SESSION['translation_'.__FUNCTION__]['param']['LanguageCode'] = $_POST['LanguageCode'];
			$_SESSION['translation_'.__FUNCTION__]['param']['Section'] = $_POST['Section'];
			$_SESSION['translation_'.__FUNCTION__]['param']['OriginalText'] = $_POST['OriginalText'];
			$_SESSION['translation_'.__FUNCTION__]['param']['TranslatedText'] = $_POST['TranslatedText'];

			// Set Query Variable
			$_SESSION['translation_'.__FUNCTION__]['query_condition'] = $query_condition;
			$_SESSION['translation_'.__FUNCTION__]['query_title'] = "Search Results";
		}

		// Reset query conditions
		if ($_GET['page']=="all")
		{
			$_GET['page'] = "";
			unset($_SESSION['translation_'.__FUNCTION__]);
		}

		// Determine Title
		if (isset($_SESSION['translation_'.__FUNCTION__]))
		{
			$query_title = "Search Results";
            $search = "on";
		}
		else
		{
			$query_title = "All Results";
            $search = "off";
		}

		// Prepare Pagination
		$query_count = "SELECT COUNT(*) AS num FROM translation ".$_SESSION['translation_'.__FUNCTION__]['query_condition'];
		$total_pages = $this->dbconnect->query($query_count)->fetchColumn();

		$targetpage = $data['config']['SITE_DIR'].'/admin/translation/index';
		$limit = 10;
		$stages = 3;
		$page = mysql_escape_string($_GET['page']);
		if ($page) {
			$start = ($page - 1) * $limit;
		} else {
			$start = 0;
		}

		// Initialize Pagination
		$paginate = $crud->paginate($targetpage,$total_pages,$limit,$stages,$page);

		$sql = "SELECT * FROM translation ".$_SESSION['translation_'.__FUNCTION__]['query_condition']." ORDER BY LanguageCode ASC LIMIT $start, $limit";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'LanguageCode' => $row['LanguageCode'],
			'Section' => $row['Section'],
			'OriginalText' => $row['OriginalText'],
			'TranslatedText' => $row['TranslatedText']);

			$i += 1;
		}

                // Set breadcrumb
                /*$breadcrumb = array(
                    array("Title" => $this->module['translation']['name'], "Link" => "")
                );*/

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Translations", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/index.inc.php', 'translation_delete' => $_SESSION['admin']['translation_delete']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.translation_common.inc.php'),
                'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,""),
		'content' => $result,
		'content_param' => array('count' => $i, 'total_results' => $total_pages, 'paginate' => $paginate, 'query_title' => $query_title, 'search' => $search, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['translation_delete']);

		return $this->output;
	}

	public function AdminAdd($param)
	{
        // Set breadcrumb
        /*$breadcrumb = array(
            array("Title" => $this->module['translation']['name'], "Link" => $this->module['translation']['admin_url']),
            array("Title" => "Create Translation", "Link" => "")
        );*/

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Create Translation", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/add.inc.php', 'translation_add' => $_SESSION['admin']['translation_add']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.translation_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Create Translation"),
		'content_param' => array('enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['translation_add']);

		return $this->output;
	}

	public function AdminAddProcess($param)
	{
		$key = "(LanguageCode, Section, OriginalText, TranslatedText)";
		$value = "('".$_POST['LanguageCode']."', '".$_POST['Section']."', '".$_POST['OriginalText']."', '".$_POST['TranslatedText']."')";

		$sql = "INSERT INTO translation ".$key." VALUES ". $value;

		$count = $this->dbconnect->exec($sql);
		$newID = $this->dbconnect->lastInsertId();

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Creating Translation...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count, 'newID' => $newID),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminEdit($param)
	{
		$sql = "SELECT * FROM translation WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'LanguageCode' => $row['LanguageCode'],
			'Section' => $row['Section'],
			'OriginalText' => $row['OriginalText'],
			'TranslatedText' => $row['TranslatedText']);

			$i += 1;
		}

        // Set breadcrumb
        /*$breadcrumb = array(
            array("Title" => $this->module['translation']['name'], "Link" => $this->module['translation']['admin_url']),
            array("Title" => "Edit Translation", "Link" => "")
        );*/

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Edit Translation", 'template' => 'admin.common.tpl.php', 'custom_inc' => 'on', 'custom_inc_loc' => $this->module_dir.'inc/admin/edit.inc.php', 'translation_add' => $_SESSION['admin']['translation_add'], 'translation_edit' => $_SESSION['admin']['translation_edit']),
		'block' => array('side_nav' => $this->module_dir.'inc/admin/side_nav.translation_common.inc.php'),
        'breadcrumb' => HTML::getBreadcrumb($this->module_name,$this->module_default_admin_url,"admin",$this->config,"Edit Translation"),
		'content' => $result,
		'content_param' => array('count' => $i, 'enabled_list' => CRUD::getActiveList()),
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		unset($_SESSION['admin']['translation_add']);
		unset($_SESSION['admin']['translation_edit']);

		return $this->output;
	}

	public function AdminEditProcess($param)
	{
		$sql = "UPDATE translation SET LanguageCode='".$_POST['LanguageCode']."', Section='".$_POST['Section']."', OriginalText='".$_POST['OriginalText']."', TranslatedText='".$_POST['TranslatedText']."' WHERE ID='".$param."'";

		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count<=1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Editing Translation...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function AdminDelete($param)
	{
		$sql = "DELETE FROM translation WHERE ID ='".$param."'";
		$count = $this->dbconnect->exec($sql);

		// Set Status
        $ok = ($count==1) ? 1 : "";

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Deleting Translation...", 'template' => 'admin.common.tpl.php'),
		'content_param' => array('count' => $count),
		'status' => array('ok' => $ok, 'error' => $error),
		'meta' => array('active' => "on"));

		return $this->output;
	}

	public function getTranslation($param, $column = "")
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM translation WHERE ID = '".$param."'";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'LanguageCode' => $row['LanguageCode'],
			'Section' => $row['Section'],
			'OriginalText' => $row['OriginalText'],
			'TranslatedText' => $row['TranslatedText']);

			$i += 1;
		}

		// Determine if get all fields or one specific field
        if ($column!="")
        {
            $result = $result[0][$column];
        }
        else
        {
            $result = $result[0];
        }

		return $result;
	}

	public function getTranslationList()
	{
		$crud = new CRUD();

		$sql = "SELECT * FROM translation ORDER BY LanguageCode DESC";

		$result = array();
		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result[$i] = array(
			'ID' => $row['ID'],
			'LanguageCode' => $row['LanguageCode'],
			'Section' => $row['Section'],
			'OriginalText' => $row['OriginalText'],
			'TranslatedText' => $row['TranslatedText']);

			$i += 1;
		}

		$result['count'] = $i;

		return $result;
	}

    public function translate($original_text, $section)
    {
        $crud = new CRUD();

        #$sql = "SELECT * FROM translation WHERE OriginalText = '".$original_text."' AND Section = '".$section."' AND LanguageCode = '".$_SESSION['Language']."'";
        $sql = "SELECT * FROM translation WHERE OriginalText = '".$original_text."' AND Section = '".$section."' AND LanguageCode = '".$_SESSION['language']."'";
        /*echo $sql;
        exit;*/
        $result = array();
        $i = 0;
        foreach ($this->dbconnect->query($sql) as $row)
        {
            $result[$i] = array(
            'ID' => $row['ID'],
            'LanguageCode' => $row['LanguageCode'],
            'Section' => $row['Section'],
            'OriginalText' => $row['OriginalText'],
            'TranslatedText' => $row['TranslatedText']);

            $i += 1;
        }

        if ($i==0)
        {
            $result = $original_text;
        }
        else
        {
            $result = $result[0]['TranslatedText'];
        }

        return $result;
    }

	public function AdminExport($param)
	{
		$sql = "SELECT * FROM translation ".$_SESSION['translation_'.$param]['query_condition']." ORDER BY LanguageCode ASC";
                
                
		$result = array();

		$result['filename'] = $this->config['SITE_NAME']."_Translation";
		$result['header'] = $this->config['SITE_NAME']." | Translation (" . date('Y-m-d H:i:s') . ")\n\nID, Language Code, Section, Original Text, Translated Text";
		$result['content'] = '';

		$i = 0;
		foreach ($this->dbconnect->query($sql) as $row)
		{
			$result['content'] .= "\"".$row['ID']."\",";
			$result['content'] .= "\"".$row['LanguageCode']."\",";
			$result['content'] .= "\"".$row['Section']."\",";
			$result['content'] .= "\"".$row['OriginalText']."\",";
			$result['content'] .= "\"".$row['TranslatedText']."\"\n";

			$i += 1;
		}

		$this->output = array(
		'config' => $this->config,
		'page' => array('title' => "Exporting..."),
		'content' => $result,
		'secure' => TRUE,
		'meta' => array('active' => "on"));

		return $this->output;
	}
}
?>