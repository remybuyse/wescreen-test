<?php class Utils {
	public static function formatUrl($var) {
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
        if(count($espaceArray) > 1) $var = Utils::removeCommonWords($var);
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
	public static function removeCommonWords($var) { 
        $commonWords = array(
            'a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','ain\'t',
            'all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another',
            'any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s',
            'aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming',
            'been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came',
            'can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.','com','come','comes','concerning',
            'consequently','consider','considering','contain','containing','contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t',
            'definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each',
            'edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody',
            'everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following',
            'follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes',
            'going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello',
            'help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how',
            'howbeit','however','hundred','i','i\'d','ie','if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates',
            'inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know',
            'known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely','likewise','little','look','looking',
            'looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t',
            'mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary',
            'need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone',
            'no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one',
            'ones','one\'s','only','onto','opposite','or','other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own',
            'p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv',
            'r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same',
            'saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously',
            'seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone',
            'something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken',
            'taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then',
            'thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they',
            'they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through',
            'throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under',
            'underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v',
            'value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re',
            'weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s',
            'whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose',
            'why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re',
            'yours','yourself','yourselves','you\'ve','z','zero',
            'alors','au','aucuns','aussi','autre','avant','avec','avoir','bon','c\'','car','ce','cela','ces','ceux','chaque','ci',
            'comme','comment','ça','ca','chez','cet','cette','d\'','dans','des','du','dedans','dehors','depuis','deux','devrait','doit','donc','dos','droite','de',
            'début','elle','elles','en','encore','essai','est','et','étaient','état','étions','été','être','eu','fait','faites',
            'fois','font','force','haut','hors','ici','il','ils','je','juste','l\'','la','le','les','leur','là','ma','maintenant',
            'mais','mes','mine','moins','mon','mot','même','ni','ne','non','nommés','notre','nous','nouveaux','oui','ou','où','par','parce',
            'parole','pas','personnes','peut','peu','pièce','plupart','pour','pourquoi','quand','que','quel','quelle','quelles',
            'quels','qui','sa','sans','ses','seulement','si','sien','son','sont','sous','soyez','sujet','sur','ta','tandis',
            'tellement','tels','tes','ton','tous','tout','trop','très','tu','un','une','valeur','voie','voient','vont','votre','vous','vu','vos','zero'
        );

        return preg_replace('/\b('.implode('|',$commonWords).')\b/','',$var);
    }
    public static function dateStr($date, $type = 'date'){
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
}