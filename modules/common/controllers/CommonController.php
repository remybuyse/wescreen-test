<?php
class CommonController{
    public $layout;
    public $module;
    public $view;
    public $formError;
    public $cache;

    public function __construct(){
        $this->layout    = array();
        $this->module    = '';
        $this->view      = array();
        $this->formError = array();
        $this->layout['description'] = '';
        $this->view['formDatas']     = '';
        $this->view['showErrorMsg']  = '';
        $this->view['formElError']   = array();
        $this->view['h1'] = true;
        $this->layout['formOk'] = 0;

        // $this->layout['referer'] = $this->getReferer();
        //$this->layout['referer'] = 'local';
        //récupération du referer si pas null
        if(!empty($this->layout['referer'])){
            $_SESSION['referer'] = $this->layout['referer'];
        }
    }

    public function setViewInLayout($view){
            require_once 'layouts/header.php';
            require_once $view;
            require_once 'layouts/footer.php';
    }

    public function setViewInAdminLayout($view){
        require_once 'layouts/admin/header.php';
        require_once $view;
        require_once 'layouts/admin/footer.php';
    }

    public function pageError($errorType){
        require_once 'modules/common/controllers/ErrorController.php';
        $errorController = new ErrorController();
        $errorController->errorAction($errorType);
    }

    public function formatPost($post){
        $datas = array();
        foreach($post as $key=>$value){
            if(!is_array($value)) $datas[$key] = trim(strip_tags(stripslashes($value)));
        }
        unset($datas['submit_x']);
        unset($datas['submit_y']);

        return $datas;
    }

    public function showErrorPost($errors){
        if(!empty($errors)) {
            $errorStr  = '';
            $errorStr  = '<div class="formError">';
            $errorStr .= '<ul>';
            foreach($errors as $error)
            {
                $errorStr .= '<li>'. $error .'</li>';
            }
            $errorStr .= '<ul>';
            $errorStr .= '</div>';
            return $errorStr;
        }
    }

    public function getIp(){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function validMail($email){
        $email = trim($email);

        // Liste mail jetable
        $disposable_email = array('jetable', 'yopmail', 'spaml', 'temporaryinbox', 'deadaddress', 'despam', 'mytempemail', 'saynotospams', 'mailinator2', 'sogetthis', 'mailin8r', 'mailinator', 'spamherelots', 'thisisnotmyrealemail', 'eyepaste', 'fornow', 'guerrillamailblock', 'incognitomail', 'beeoh', 'keepmymail', 'mailcatch', 'mailscrap', 'meltmail', 'bsnow', '12minutemail', 'mt2009', 'no-spam', 'sneakemail', 'spamjackal', 'spamavert', 'spambox', 'trashmail', '10x9', 'spamgourmet', '0-mail', 'haltospam', 'link2mail', 'tempinbox', 'explodemail', 'slaskpost', 'spailbox', 'slopsbox', 'realcambio', 'spam.w00ttech', 'watchnode.uni', 'gimme.wa.rez', 'pyramidspel', 'spam.dontassrape', 'slopsbox.osocial', 'freenet6', 'casema', 'hushmail', 'dispostable', '10minutemail', '20minutemail', 'katamail', '*beep*', 'ard', '0815', '0sg', '0wnd', '12hourmail', '1chuan', '1zhuan', '21cn', '2prong', '3126', '3d-painting', '3g', '4warding', '50eo', '6url', '9ox', 'a-bc', 'abwesend', 'addcom', 'agnitumhost', 'alpenjodel', 'alphafrau', 'amorki', 'anonbox', 'anonymbox', 'antichef', 'antispam', 'antispam24', 'autosfromus', 'baldmama', 'baldpapa', 'ballyfinance', 'betriebsdirektor', 'bigmir', 'bin-wieder-da', 'bio-mueslio', 'bio-muesli', 'bk', 'bleib-bei-mir', 'blockfilter', 'bluebottle', 'bodhilita', 'bonbon', 'briefemail', 'brokenvalve', 'bspamfree', 'buerotiger', 'bugmenot', 'bumpymail', 'buy-24h', 'cashette', 'center-mail', 'centermail', 'centermailo', 'cghost-d', 'chongsoft', 'coolnf', 'coole-files', 'cosmorph', 'courrielnf', 'curryworld', 'cust', 'cyber-matrix', 'dandikmail', 'dating4best', 'deadspam', 'despammed', 'dfgh', 'die-besten-bilder', 'die-genossen', 'die-optimisten', 'dieMailbox', 'digital-filestore', 'directbox', 'discardmail', 'discartmail', 'disposeamail', 'docmail', 'dodgeit', 'dodgit', 'dogit', 'dontreg', 'dontsendmespam', 'dontsentmespam', 'download-privat', 'dumpandjunk', 'dumpmail', 'dyndns', 'e-mail', 'e4ward', 'eintagsmail', 'email', 'email4uo', 'emaildienst', 'emailias', 'emailmiser', 'emailtaxi', 'emailto', 'emailwarden', 'example', 'fahr-zur-hoelle', 'fakeinformation', 'falseaddress', 'fantasymail', 'fariflusetlexpire', 'fastacura', 'fastchevy', 'fastchrysler', 'fastkawasaki', 'fastmazda', 'fastmitsubishi', 'fastnissan', 'fastsubaru', 'fastsuzuki', 'fasttoyota', 'fastyamaha', 'feinripptraeger', 'fettabernett', 'filzmail', 'fishfuse', 'forgetmail', 'freemeilaadressforall', 'freudenkinder', 'fromru', 'front14', 'gawab', 'gentlemansclub', 'getonemail', 'ghosttexter', 'gishpuppy', 'gold-profitso', 'goldtoolbox', 'golfillao', 'great-host', 'greensloth', 'guerillamail', 'guerrillamail', 'guerrillamailo', 'h8s', 'hab-verschlafen', 'habmalnefrage', 'hatespam', 'herr-der-mails', 'hidemail', 'home', 'hush', 'i', 'ich-bin-verrueckt-nach-dir', 'ich-will-net', 'imailso', 'imstations', 'inbox', 'inbox2o', 'inboxclean', 'inerted', 'inet', 'inmail24', 'ipoo', 'ist-alleino', 'ist-einmalig', 'ist-ganz-allein', 'ist-willig', 'izmail', 'jetablenf', 'jetfix', 'jetzt-bin-ich-dran', 'jn-club', 'junkmail', 'kaffeeschluerfer', 'kasmail', 'killmail', 'kinglibrary', 'klassmaster', 'kommespaeter', 'krim', 'kuh', 'kulturbetriebo', 'lass-es-geschehen', 'liebt-dicho', 'list', 'listomail', 'litedrop', 'lol', 'lortemail', 'loveyouforever', 'maennerversteherin', 'mail22', 'mailterpinball', 'mailnz', 'mail15', 'mail2rss', 'mail333', 'mail4days', 'mail4uo', 'mailblocks', 'mailbucket', 'maileater', 'mailexpire', 'mailfreeonline', 'mailinater', 'mailinblack', 'mailmoat', 'mailnull', 'mailquack', 'mailshell', 'mailsiphon', 'mailtrash', 'mailueberfall', 'mailzilla', 'makemetheking', 'mamber', 'meine-dateieno', 'meine-diashow', 'meine-fotoso', 'meine-urlaubsfotos', 'meinspamschutz', 'messagebeamer', 'metaping', 'mintemail', 'mns', 'moncourriernf', 'monemailnf', 'monmailnf','monmail', 'mufmail', 'muskelshirt', 'mx0new', 'my-mail', 'myadulto', 'mycleaninbox', 'mymail-in', 'mytop-in', 'mytrashmail', 'mytrashmailpookmail', 'nervmich', 'nervtmich', 'netmails', 'netterchef', 'netzidiot', 'neue-dateien', 'neverbox', 'nm', 'nobulk', 'nomail2me', 'nospam4', 'nospamfor', 'nospammail', 'nowmymail', 'nullboxo', 'nur-fuer-spam', 'nurfuerspam', 'nybella', 'office-dateien', 'oikrach', 'oneoffemail', 'oopi', 'open', 'orangatango', 'partybombe', 'partyheld', 'phreaker', 'pisem', 'pleasedontsendmespam', 'polizisten-duzer', 'poofy', 'pookmail', 'pornobilder-mal-gratis', 'portsaid', 'postfach', 'privacy', 'prydirecto', 'pryworldo', 'public-files', 'punkass', 'put2', 'quantentunnel', 'qv7o', 'ralib', 'raubtierbaendiger', 'recode', 'record', 'recursor', 'rejectmail', 'rootprompt', 'saeuferleber', 'safe-mail', 'safersignup', 'sags-per-mail', 'sandelf', 'satka', 'schmusemail', 'schreib-doch-mal-wieder', 'senseless-entertainment', 'shared-files', 'shieldedmail', 'shinedyoureyes', 'shortmail', 'sibmail', 'siria', 'skeefmail', 'sms', 'sofort-mail', 'sofortmail', 'sonnenkinder', 'soodonims', 'spam', 'spambob', 'spambog', 'spamcannon', 'spamcon', 'spamcorptastic', 'spamcowboy', 'spamday', 'spameater', 'spamex', 'spamfree24', 'spamfree24o', 'spamgrube', 'spamhole', 'spamify', 'spaminator', 'spammote', 'spammotel', 'spammuffel', 'spamoff', 'spamreturn', 'spamspot', 'spamtrail', 'sperke', 'sriaus', 'streber24', 'super-auswahl', 'sweetville', 'tagesmail', 'teewars', 'temp-mail', 'tempe-mail', 'tempemail', 'tempomail', 'temporarily', 'temporaryforwarding', 'terminverpennt', 'test', 'thepryamo', 'topmail-files', 'tortenboxer', 'totalmail', 'trash-mail', 'trashbox', 'trashdevil', 'trashymail', 'trimix', 'turboprinz', 'turboprinzessin', 'tut', 'twinmail', 'ua', 'uk2', 'ukr', 'unterderbruecke', 'verlass-mich-nicht', 'vinbazar', 'vollbio', 'volloeko', 'vorsicht-bissig', 'vorsicht-scharf', 'walala', 'war-im-urlaub', 'wbb3', 'webmail4u', 'wegwerfadresse', 'wegwerfemail', 'weibsvolk', 'weinenvorglueck', 'wh4f', 'whopy', 'will-hier-weg', 'willhackforfood', 'wir-haben-nachwuchs', 'wir-sind-cool', 'wirsindcool', 'wolke7', 'women-at-work', 'wormseo', 'wronghead', 'wuzup', 'xents', 'xmail', 'xmaily', 'xoxy', 'xsecurity', 'yesey', 'yopweb', 'youmailr', 'ystea', 'yzbid', 'zoemail', 'zweb', '675hosting', '75hosting', 'ajaxapp', 'amiri', 'amiriindustries', 'anonymail', 'buyusedlibrarybooks', 'etranquil', 'gowikibooks', 'gowikicampus', 'gowikicars', 'gowikifilms', 'gowikigames', 'gowikimusic', 'gowikinetwork', 'gowikitravel', 'gowikitv', 'ichimail', 'mailslapping', 'myspaceinc', 'myspacepimpedup', 'noclickemail', 'oneoffmail', 'ourklips', 'pimpedupmyspace', 'recyclemail', 'rklips', 'turual', 'upliftnow', 'uplipht', 'viditag', 'viewcastmedia', 'wetrainbayarea', 'willselfdestruct', 'wilemail', 'xagloo', 'thankyou2010', 'f.mintemail', 'fakemail', 'tilien', 'maboard', 'tempmail', 'f.mintemail');

        $whitelist = array("email", "hush", "adfinitas", "hotmail", "live", "yahoo", "gmail", "voila", "laposte", "wanadoo", "orange", "sfr", "lagencetorich", "torich", "nordnet", "numericable", "aol", "neuf", "msn", "comcast", "ntlworld", "clubinternet", "verizon", "wokine", "lautremedia", "cox", "earthlink", "free", "sfr", "boulanger", "gmx", "touteslespetitions");

        // On verifie la validité de l'adresse mail
        if(preg_match('`^[[:alnum:]]([-_.+]?[[:alnum:]])+_?@[[:alnum:]]([-.]?[[:alnum:]])+\.[a-z]{2,6}$`', $email)){

            // On verifie si elle n'est pas dans la liste des emails jetables
            $aEmail = explode('@', $email);
            $aDomain = explode('.', $aEmail[1]);
            $domain = $aDomain[0];

            if(in_array($domain, $whitelist)){
                return 1;
            }
            else{
                if(in_array($domain, $disposable_email)){             // On verifie si l'email n'est pas un email jetable
                    return 0;
                } else{
                    $explode = explode("@",$email);
                    $end = end($explode);
                    // On verifie si le nom de domaine existe
                    if(checkdnsrr($end,"MX")){
                        return 1;
                    } else{
                        return 0;
                    }
                }
            }

        } else{
            return 0;
        }
    }

    //Permet d'envoyer un email via la class PhpMailer
    //Paramètres : sender->@ émettrice, alias->nom de l'emetteur, email->chemin de l'email à envoyer, text->chemin de la version texte de l'email(mettre à false si pas de version texte)
    //variables->tableau avec le nom de variables, data->tableau avec le contenu des variables
    public function envoiEmail($sender, $alias, $sujet, $email, $text, $recieverMail, $recieverName, $variables, $data){
        require_once 'lib/phpmailer/class.phpmailer.php';

        //Config du mail
        $mail = new PHPMailer();
        $mail->IsHTML(true);
        $mail->CharSet = "utf-8";
        $mail->SetFrom($sender, $alias);
        $mail->Subject = $sujet;
        $mail->AddAddress($recieverMail, $recieverName);
        //Version Texte
        if($text){
            $mail->AltBody = file_get_contents($text);
        }
        //Version Html
        $body = file_get_contents($email);
        //Variables
        $vars = $variables;
        $values = $data;
        $body = str_replace($vars,$values,$body);
        //html
        $mail->MsgHTML($body);
        //Envoi
        $mail->Send();
    }

    public function charFormat($string, $case = 'ucfirst'){
        $lower_char = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ì", "í", "î", "ï", "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "а", "б", "в", "г", "д", "е", "ё", "ж", "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы", "ь", "э", "ю", "я");

        $upper_char = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "À", "Á", "Â", "Ã", "Ä", "Å", "Æ", "Ç", "È", "É", "Ê", "Ë", "Ì", "Í", "Î", "Ï", "Ð", "Ñ", "Ò", "Ó", "Ô", "Õ", "Ö", "Ø", "Ù", "Ú", "Û", "Ü", "Ý", "А", "Б", "В", "Г", "Д", "Е", "Ё", "Ж", "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р", "С", "Т", "У", "Ф", "Х", "Ц", "Ч", "Ш", "Щ", "Ъ", "Ъ", "Ь", "Э", "Ю", "Я");

        $special = array("à", "á", "â", "ã", "ä", "å", "æ", "ç", "è", "é", "ê", "ë", "ì", "í", "î", "ï", "ð", "ñ", "ò", "ó", "ô", "õ", "ö", "ø", "ù", "ú", "û", "ü", "ý", "а", "б", "в", "г", "д", "е", "ё", "ж", "з", "и", "й", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "ъ", "ы", "ь", "э", "ю", "я");

        switch ($case){
            case "upper" :
                return str_replace($lower_char, $upper_char, $string);
                break;

            case "lower" :
                return str_replace($upper_char, $lower_char, $string);
                break;

            case "ucfirst" :
            default:
                if (in_array(substr($string, 0, 2), $special)){
                    $length = 2;
                }
                else{
                    $length = 1;
                }
                return (str_replace($lower_char, $upper_char, substr($string, 0, $length)) . str_replace($upper_char, $lower_char, substr($string, $length, strlen($string) - 1)));
                break;
        }
    }

    // Check données formulaire d'inscription ?
    public function checkSubscriptionForm($post, $account = false){
        if(empty($this->view['formDatas']['fname'])){
            // Erreurs
            $this->formError[] = _ERROR_NO_FNAME;
            $this->view['formElError']['fname'] = true;
        }
        if(empty($this->view['formDatas']['name'])){
            // Erreurs
            $this->formError[] = _ERROR_NO_NAME;
            $this->view['formElError']['name'] = true;
        }
        if($account){
            if($this->view['formDatas']['gender'] == ''){
                // Erreurs
                $this->formError[] = _ERROR_NO_TITLE;
            }

            if(empty($post['email'])){
                // Erreurs
                $this->formError[] = _ERROR_NO_EMAIL;
                $this->view['formElError']['email'] = true;
            }
            elseif(!$this->validMail($post['email'])){
                // Erreurs
                $this->formError[] = _ERROR_EMAIL;
                $this->view['formElError']['email'] = true;
            }
            if(!$_SESSION['from']){
                if(!$account){
                    if(strlen($this->view['formDatas']['day']) < 2 || !is_numeric($this->view['formDatas']['day']) || ($this->view['formDatas']['day'] < 1 || $this->view['formDatas']['day'] > 31)){
                        // Erreurs
                        $this->formError['birthdate'] = _ERROR_BDATE;
                        $this->view['formElError']['day'] = true;
                    }
                    if(strlen($this->view['formDatas']['month']) < 2 || !is_numeric($this->view['formDatas']['month']) || ($this->view['formDatas']['month'] < 1 || $this->view['formDatas']['month'] > 12)){
                        // Erreurs
                        $this->formError['birthdate'] = _ERROR_BDATE;
                        $this->view['formElError']['month'] = true;
                    }
                    if(!is_numeric($this->view['formDatas']['year']) || ($this->view['formDatas']['year'] < 1901 || $this->view['formDatas']['year'] >= (date('Y')))){
                        // Erreurs
                        $this->formError['birthdate'] = _ERROR_BDATE;
                        $this->view['formElError']['year'] = true;
                    }
                }
                else{
                    if(empty($this->view['formDatas']['login'])){
                        // Erreurs
                        $this->formError[] = _ERROR_NO_LOGIN;
                        $this->view['formElError']['login'] = true;
                    }
                    elseif(strlen($this->view['formDatas']['login']) < 4 || strlen($this->view['formDatas']['login']) > 20){
                        // Erreurs
                        $this->formError[] = _ERROR_LENGTH_LOGIN;
                        $this->view['formElError']['login'] = true;
                    }
                    if(empty($this->view['formDatas']['password'])){
                        // Erreurs
                        $this->formError[] = _ERROR_NO_PASSWORD;
                        $this->view['formElError']['password'] = true;
                    }
                    elseif(strlen($this->view['formDatas']['password']) < 4 || strlen($this->view['formDatas']['password']) > 10){
                        // Erreurs
                        $this->formError[] = _ERROR_LENGTH_PASSWORD;
                        $this->view['formElError']['password'] = true;
                    }
                    if(empty($this->view['formDatas']['password-confirm'])){
                        // Erreurs
                        $this->formError[] = _ERROR_NO_PASSWORD_CONFIRM;
                        $this->view['formElError']['password-confirm'] = true;
                    }
                    if((!empty($this->view['formDatas']['password']) && !empty($this->view['formDatas']['password-confirm'])) && ($this->view['formDatas']['password'] != $this->view['formDatas']['password-confirm'])){
                        // Erreurs
                        $this->formError[] = _ERROR_PASSWORD_COMPARE;
                        $this->view['formElError']['password'] = true;
                        $this->view['formElError']['password-confirm'] = true;
                    }
                }
            }
            if(empty($this->view['formDatas']['address'])){
                // Erreurs
                $this->formError[] = _ERROR_NO_ADDR;
                $this->view['formElError']['address'] = true;
            }
            if(!$_SESSION['from']){
                if(empty($this->view['formDatas']['zipcode'])){
                    // Erreurs
                    $this->formError[] = _ERROR_NO_ZIPCODE;
                    $this->view['formElError']['zipcode'] = true;
                }
                if(empty($this->view['formDatas']['country'])){
                    // Erreurs
                    $this->formError[] = _ERROR_NO_COUNTRY;
                    $this->view['formElError']['country'] = true;
                }
            }
            if(empty($this->view['formDatas']['city'])){
                // Erreurs
                $this->formError[] = _ERROR_NO_CITY;
                $this->view['formElError']['city'] = true;
            }
        }

        // Affichage des messages d'erreurs
        return $this->showErrorPost($this->formError, true);
    }

    public function getCurlPage($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $tmp = curl_exec ($ch);
        curl_close ($ch);
        return $tmp;
    }

    public function dateStr($date, $type = 'date'){
        $date = strtotime($date);

        switch($type){
            case 'full':
            // DAY
            $weekDays = array(_SUNDAY,_MONDAY,_TUESDAY,_WEDNESDAY,_THURSDAY,_FRIDAY,_SATURDAY);
            $nDay = date('w', $date);
            $weekday = $weekDays[$nDay];

            // MONTH
            $months = array(' ',_JANUARY,_FEBRUARY,_MARCH,_APRIL,_MAY,_JUNE,_JULY,_AUGUST,_SEPTEMBER,_OCTOBER,_NOVEMBER,_DECEMBER);
            $nMonth = date("n", $date);
            $month = $months[$nMonth];

            if(LANG == 'fr') $return = $weekday . ' ' . date('d', $date) . ' ' . $month . ' ' . date('Y', $date);
            elseif(LANG == 'en') $return = $weekday . ', ' . $month . date('d', $date) . ', ' . date('Y', $date);
            break;

            case 'short':
            if(LANG == 'fr') $return = date('d', $date) . ' ' . $month . ' ' . date('Y', $date);
            elseif(LANG == 'en') $return = $month . date('d', $date) . ', ' . date('Y', $date);
            break;

            case 'date':
            if(LANG == 'fr') $return = date('d', $date) . '/' . date("m", $date) . '/' . date('Y', $date);
            elseif(LANG == 'en') $return = date('Y', $date) . '/' . date("m", $date) . '/' . date('d', $date);
            break;

            case 'dateHourDate':
            if(LANG == 'fr') $return = date('d', $date) . '/' . date("m", $date) . '/' . date('Y', $date) . ' ';
            elseif(LANG == 'en') $return = date('Y', $date) . '/' . date("m", $date) . '/' . date('d', $date) . ' ';
            $return .= date('H', $date) . ':' . date('i', $date) . ':' . date('s', $date);
            break;

            case 'dateHour':
            if(LANG == 'fr') $return = 'Le ' . date('d', $date) . '/' . date("m", $date) . '/' . date('Y', $date) . ' à ';
            elseif(LANG == 'en') $return = 'The ' . date('Y', $date) . '/' . date("m", $date) . '/' . date('d', $date) . ' at ';
            $return .= date('H', $date) . ':' . date('i', $date) . ':' . date('s', $date);
            break;
        }

        return $return;
    }

    public function redirect($url){
        header("location: $url");
        exit();
    }

    public function getPaginatorOption($nbItem = null){
        $currentPage = 1;

        if(empty($nbItem)) $nbItem = NB_ITEM_LIST_DISP;

        if(isset($_GET['page']) && $_GET['page'] != ''){
            $currentPage = (int)$_GET['page'];
            if($currentPage == 0) $currentPage = 1;
        }

        return array(
            'currentPage' => $currentPage,
            'offset' => ($currentPage - 1) * $nbItem
        );
    }

    public function paginatorGenerator($pagesCt, $currentPage, $url, $anchor = null){
        $page = 1;
        $paginator = '';

        if($pagesCt > 1){
            if($_SESSION['mobile']=='1'){
            $paginator .= '<ul class="left clearfix">';
            }else{
                $paginator .= '<ul class="left clearfix"><li><span class="bold">' . _PAGE . '</span></li>';
            }
            if($pagesCt < 11){
                while($page <= $pagesCt){
                    $paginator .= '<li><a class="backcolrhover';
                    $paginator .= ($page == $currentPage) ? ' backcolr" ' : '" ';
                    $paginator .= ($page == 1) ? 'href="' . $url . $anchor . '">' : 'href="' . $url . 'page'. $page . $anchor .'">';
                    $paginator .= $page . '</a></li>';
                    $page++;
                }
            }
            else{
                if($currentPage < 6){
                    while($page <= 6){
                        $paginator .= '<li><a class="backcolrhover';
                        $paginator .= ($page == $currentPage) ? ' backcolr" ' : '" ';
                        $paginator .= ($page == 1) ? 'href="' . $url . $anchor . '">' : 'href="' . $url . 'page'. $page . $anchor . '">';
                        $paginator .= $page . '</a></li>';
                        $page++;
                    }
                    $lastpages1 = floor(6 + (($pagesCt - 6) / 4));
                    $lastpages2 = floor(6 + (($pagesCt - 6) / 2));
                    $lastpages3 = floor(6 + (($pagesCt - 6) * 0.75));
                    $paginator .= ($page == $lastpages1) ? '<li>' : '<li> ... ';
                    $paginator .= '<a class="backcolrhover" href="' . $url . 'page' . $lastpages1 . $anchor . '">' . $lastpages1 . '</a></li>';
                    $paginator .= ($lastpages2 == $lastpages1 + 1) ? '<li>' : '<li> ... ';
                    $paginator .= '<a class="backcolrhover" href="' . $url . 'page' . $lastpages2 . $anchor . '">' . $lastpages2 . '</a></li>';
                    $paginator .= ($lastpages2 == $lastpages3 + 1) ? '<li>' : '<li> ... ';
                    $paginator .= '<a class="backcolrhover" href="' . $url . 'page' . $lastpages3 . $anchor . '">' . $lastpages3 . '</a>';
                    $paginator .= ($lastpages3 + 1 == $pagesCt) ? '</li>' : ' ... </li>';
                }
                elseif($currentPage >= ($pagesCt - 4)){
                    $paginator .= '<li><a class="backcolrhover" href="' . $url . $anchor . '">1</a></li>';
                    $firstpages1 = floor(1 + (($pagesCt - 6) / 4));
                    $firstpages2 = floor(1 + (($pagesCt - 6) / 2));
                    $firstpages3 = floor(1 + (($pagesCt - 6) * 0.75));
                    $paginator .= ($firstpages1 == 2) ? '<li>' : '<li> ... ';
                    $paginator .= '<a class="backcolrhover" href="' . $url . 'page'. $firstpages1 . $anchor . '">' . $firstpages1 . '</a></li>';
                    $paginator .= ($firstpages2 == $firstpages1 + 1) ? '<li>' : '<li> ... ';
                    $paginator .= '<a class="backcolrhover" href="' . $url . 'page' . $firstpages2 . $anchor . '">' . $firstpages2 . '</a></li>';
                    $paginator .= ($firstpages3 == $firstpages2 + 1) ? '<li>' : '<li> ... ';
                    $paginator .= '<a class="backcolrhover" href="' . $url . 'page' . $firstpages3 . $anchor . '">' . $firstpages3 . '</a>';
                    $page = $pagesCt - 5;
                    $paginator .= ($firstpages3 + 1 == $page) ? '</li>' : ' ... </li>';
                    while($page <= ($pagesCt - 1))
                    {
                        $paginator .= '<li><a class="backcolrhover';
                        $paginator .= ($page == $currentPage) ? ' backcolr" ' : '" ';
                        $paginator .= 'href="' . $url . 'page'. $page . $anchor . '">';
                        $paginator .= $page . '</a></li>';
                        $page++;
                    }
                }
                elseif($currentPage > 5 && $currentPage < ($pagesCt - 4)){
                    $paginator .= '<li><a class="backcolrhover" href="' . $url . $anchor . '">1</a></li>';
                    $page2 = 1 + (($currentPage - 3) / 3);
                    $paginator .= ($page2 == 2) ? '<li>' : '<li> ... ';
                    $paginator .= '<a class="backcolrhover" href="'. $url . 'page' . floor($page2) . $anchor . '">' . floor($page2) . '</a></li>';
                    $page3 = 1 + (($currentPage - 3) * (2/3));
                    $paginator .= ($page3 == $page2 + 1) ? '<li>' : '<li> ... ';
                    $paginator .= '<a class="backcolrhover" href="' . $url . 'page' . floor($page3) . $anchor . '">' . floor($page3) . '</a></li>';
                    $page4 = $currentPage - 2;
                    $paginator .= ($page4 == $page3 + 1) ? '<li>' : '<li> ... ';
                    $paginator .= '<a class="backcolrhover" href="' . $url . 'page' . floor($page4) . $anchor . '">' . floor($page4) . '</a></li>';
                    $page5 = $currentPage - 1;
                    $paginator .= '<li><a class="backcolrhover" href="' . $url . 'page' . floor($page5) . $anchor . '">' . floor($page5) . '</a></li>';
                    $page6 = $currentPage;
                    $paginator .= '<li><a class="backcolrhover backcolr" href="'  .$url . 'page' . floor($page6) . $anchor . '">' . floor($page6) . '</a></li>';
                    $page7 = $currentPage + 1;
                    $paginator .= '<li><a class="backcolrhover" href="' . $url . 'page' . floor($page7) . $anchor . '">' . floor($page7) . '</a></li>';
                    $page8 = $currentPage + 2;
                    $paginator .= '<li><a class="backcolrhover" href="' . $url . 'page' . floor($page8) . $anchor . '"> '. floor($page8) . '</a></li>';
                    $page9 = floor($page8 + (($pagesCt - $page4) / 3));
                    $paginator .= ($page9 == $page8 + 1) ? '<li>' : '<li> ... ';
                    $paginator .= '<a class="backcolrhover" href="' . $url . 'page' . $page9 . $anchor . '">' . $page9 . '</a>';
                    $page10 = floor(($currentPage) + 2 + (($pagesCt-$currentPage-2)*(2/3)));
                    if($page9 != $page10)
                    {
                        $paginator .= ($page10 == $page9 + 1) ? '</li><li>' : '</li><li> ... ';
                        $paginator .= '<a class="backcolrhover" href="' . $url . 'page' . $page10 . $anchor . '">' . $page10 . '</a>';
                        $paginator .= ($pagesCt == $page10 + 1) ? '</li>' : ' ... </li>';
                    } else $paginator .= ($pagesCt == $page9 + 1) ? '</li>' : ' ... </li>';
                }
                $paginator .= '<li><a class="backcolrhover';
                $paginator .= ($pagesCt == $currentPage) ? ' backcolr" ' : '" ';
                $paginator .= 'href="' . $url . 'page'. $pagesCt . $anchor . '">';
                $paginator .= $pagesCt . '</a></li>';
            }
            $paginator .= '</ul><ul class="right clearfix">';
            if($currentPage > 1){
                $previousPage = $currentPage - 1;
                if($_SESSION['mobile']=='1'){

                }else{
                $paginator .= ($currentPage < 3) ? '<li><a class="prevbtn backcolrhover" href="' . $url . $anchor . '">' . _PREVIOUS . '</a></li>' : '<li><a class="prevbtn backcolrhover" href="' . $url . 'page' . $previousPage . $anchor . '">' . _PREVIOUS . '</a></li>';
                }
            }
            if($currentPage < $pagesCt){
                $nextPage = $currentPage + 1;
                if($_SESSION['mobile']=='1'){

                }else{
                $paginator .= '<li><a class="nextbtn backcolrhover" href="' . $url . 'page' . $nextPage . $anchor . '">' . _NEXT . '</a></li>';
                }
            }
            $paginator .= '</ul>';
        }

        return $paginator;
    }

    public function formatForUrl($var){
        $modif = str_replace(
            array(
                'à', 'â', 'ä', 'á', 'ã', 'å',
                'î', 'ï', 'ì', 'í',
                'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
                'ù', 'û', 'ü', 'ú',
                'é', 'è', 'ê', 'ë',
                'ç', 'ÿ', 'ñ',
                'À', 'Â', 'Ä', 'Á', 'Ã', 'Å',
                'Î', 'Ï', 'Ì', 'Í',
                'Ô', 'Ö', 'Ò', 'Ó', 'Õ', 'Ø',
                'Ù', 'Û', 'Ü', 'Ú',
                'É', 'È', 'Ê', 'Ë',
                'Ç', 'Ÿ', 'Ñ'
            ),
            array(
                'a', 'a', 'a', 'a', 'a', 'a',
                'i', 'i', 'i', 'i',
                'o', 'o', 'o', 'o', 'o', 'o',
                'u', 'u', 'u', 'u',
                'e', 'e', 'e', 'e',
                'c', 'y', 'n',
                'A', 'A', 'A', 'A', 'A', 'A',
                'I', 'I', 'I', 'I',
                'O', 'O', 'O', 'O', 'O', 'O',
                'U', 'U', 'U', 'U',
                'E', 'E', 'E', 'E',
                'C', 'Y', 'N'
            ),
            $var
        );

        $var = $modif;
        $var = str_replace('?', '', $var);
        $var = strtolower($var);
        $espaceArray = explode(' ', $var);
        if(count($espaceArray) > 1) $var = $this->removeCommonWords($var);
        $var = preg_replace('/^\[.*?\]/', '', $var);
        $var = trim($var);
        $var = str_replace(' ', '-', $var);
        $var = str_replace('...', '', $var);
        $var = preg_replace('#([^a-z0-9-_])#', '-', $var);
        $var = preg_replace('#([-]+)#', '-', $var);
        if(substr($var, 0, 1) == '-') $var = substr($var, 1, strlen($var));
        if(substr($var, -1) == '-')   $var = substr($var, 0, -1);

        $varArray = explode('-', $var);
        if(count($varArray) > 6){
            $var = '';
            for($i = 0; $i <= 5; $i++){
                $var .= $varArray[$i];
                if($i != 5) $var .= '-';
            }
        }
        if(strlen($var) > 100){
            $var    = substr($var, 0, 100);
            $indent = strrpos($var, '-');
            $var    = substr($var, 0, $indent);
        }

        return $var;
    }

    public function timePassed($date){
        $timePassed = round((strtotime(date('Y-m-d H:i:s')) - strtotime($date))/(60*60*24));
        if($timePassed == 0){
            $seconds = round((strtotime(date('Y-m-d H:i:s')) - strtotime($date)));
            $temp = $seconds % 3600;
            $time = '';
            $time[0] = ( $seconds - $temp ) / 3600;
            $time[2] = $temp % 60;
            $time[1] = ( $temp - $time[2] ) / 60;
            if($time[0] > 0) $time_passed = $time[0].' '.$this->charFormat(_H, 'lower');
            if($time[1] > 0) $time_passed = ($time[0] > 0 && $time[1] < 10) ? $time_passed.' 0'.$time[1].' '.$this->charFormat(_MIN, 'lower') : $time_passed.' '.$time[1].' '.$this->charFormat(_MIN, 'lower');
            if(!$time[0] && !$time[1]) $time_passed = $time[2].' '.$this->charFormat(_SEC, 'lower');
        }
        else{
            if($timePassed >= 30 && $timePassed < 365) $time_passed = (floor($timePassed / 30) > 1) ? floor($timePassed / 30) . ' ' . $this->charFormat(_MONTHS, 'lower') : floor($timePassed / 30) . ' ' . $this->charFormat(_MONTH, 'lower');
            elseif($timePassed >= 365){
                $timePassed   = floor($timePassed / 365);
                $time_passed  = ($timePassed > 1) ? $timePassed . ' ' . $this->charFormat(_YEARS, 'lower') : $timePassed . ' ' . $this->charFormat(_YEAR, 'lower');
            }
            else $time_passed = ($timePassed > 1) ? $timePassed . ' ' . $this->charFormat(_DAYS, 'lower') : $timePassed . ' ' . $this->charFormat(_DAY, 'lower');
        }

        if(LANG == 'fr') $time_passed       = _AGO . ' ' . $this->charFormat($time_passed, 'lower');
        elseif(LANG == 'en') $time_passed   = $time_passed . ' ' . _AGO;

        return $time_passed;
    }

    public function image_resize($src, $dst, $width, $height, $w, $h){
        $type = strtolower(substr(strrchr($src,"."),1));
        if($type == 'jpeg' || $type == 'pjpeg') $type = 'jpg';
        switch($type){
            case 'bmp': $img = imagecreatefromwbmp($src); break;
            case 'gif': $img = imagecreatefromgif($src); break;
            case 'jpg': $img = imagecreatefromjpeg($src); break;
            case 'png': $img = imagecreatefrompng($src); break;
        }

        // resize
        $ratio = max($width/$w, $height/$h);
        $width  = $w * $ratio;
        $height = $h * $ratio;
        $x = 0;

        $new = imagecreatetruecolor($width, $height);

        // preserve transparency
        if($type == "gif" or $type == "png"){
            imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }

        imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

        switch($type){
            case 'bmp': imagewbmp($new, $dst); break;
            case 'gif': imagegif($new, $dst); break;
            case 'jpg': imagejpeg($new, $dst); break;
            case 'png': imagepng($new, $dst); break;
        }

        return true;
    }

    /*
    * Génère le JSON à partir d'un tableau de données.
    *
    * @param array $arr
    * @return string
    */
    public function jsonize($arr = null){
        if(empty($arr)) return "";

        $str = "";
        $count = 0;
        if(!$this->isAssoc($arr)) {
            $str .= "[";
            foreach($arr as $val) {
                $count++;
                $str .= is_array($val)
                ? $this->jsonize($val)
                : '"' . $this->replace($val) . '"';
                if($count != sizeof($arr)) $str .= ",";
            }
            $str .= "]";
        } else {
            $str .= "{";
            foreach($arr as $key=>$val) {
                $count++;
                $str .= is_array($val)
                ? '"' . $key . '":' . $this->jsonize($val)
                : '"' . $key . '":"' . $this->replace($val) . '"';
                if($count != sizeof($arr)) $str .= ",";
            }
            $str .= "}";
        }
        return $str;
    }

    /*
    * Vérifie si un tableau est de type associatif.
    *
    * @param array $array
    * @return boolean Vrai si le tableau est associatif.
    */
    private function isAssoc($array){
        foreach (array_keys($array) as $k => $v) {
            if ($k !== $v) {
                return true;
            }
        }
        return false;
    }

    /*
    * Ajoute un backslash devant les guillemets doubles
    *
    * @param string string
    * @return string Vrai si le tableau est associatif.
    */
    private function replace($str){
        $str = str_replace('\"', '"', $str);
        $str = str_replace('"', '\"', $str);
        return preg_replace('/\s+/', ' ', $str);
    }

    // public function getReferer(){
    //     if(empty($_SESSION['referer'])){
    //         //Permet de récupérer le site référant
    //         $referer_visitor = $_SERVER['HTTP_REFERER'];

    //         if(!empty($referer_visitor)){
    //             $referer_visitor = parse_url($referer_visitor, PHP_URL_HOST);

    //             return $referer_visitor;
    //         }
    //         else{
    //             return $referer_visitor;
    //         }
    //     }
    //     else{
    //         return $_SESSION['referer'];
    //     }
    // }
}