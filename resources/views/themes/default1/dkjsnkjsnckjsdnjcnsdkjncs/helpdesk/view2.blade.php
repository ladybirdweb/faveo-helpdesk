<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">

<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>WooCommerce › Setup Wizard</title>
    <script type="text/javascript" src="js/jquery.js"></script>

    <link rel="stylesheet" href="css/load-styles.css" type="text/css" media="all">
    <link rel="stylesheet" id="open-sans-css" href="css/css.css" type="text/css" media="all">
    <link rel="stylesheet" id="woocommerce_admin_styles-css" href="css/admin.css" type="text/css" media="all">
    <link rel="stylesheet" id="wc-setup-css" href="css/wc-setup.css" type="text/css" media="all">
    <link rel="stylesheet" id="woocommerce-activation-css" href="css/activation.css" type="text/css" media="all">
</head>

<body class="wc-setup wp-core-ui">
    <h1 id="wc-logo"><a href="http://woothemes.com/woocommerce"><img src="images/App-Store.app" alt="faveo"></a></h1>
    <ol class="wc-setup-steps">
        <li class="done">Page Setup</li>
        <li class="active">Store Locale</li>
        <li class="">Shipping &amp; Tax</li>
        <li class="">Payments</li>
        <li class="">Ready!</li>
    </ol>
    <div class="wc-setup-content">
        <h1>Store Locale Setup</h1>
        <form method="post">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="store_location">Where is your store based?</label>
                        </th>
                        <td>
                            <div style="width:100%;" id="s2id_store_location" class="select2-container wc-enhanced-select enhanced">
                                <label for="s2id_autogen1" class="select2-offscreen">Where is your store based?</label>
                                <input id="s2id_autogen1" aria-labelledby="select2-chosen-1" class="select2-focusser select2-offscreen" aria-haspopup="true" role="button" type="text">
                                <div class="select2-drop select2-display-none select2-with-searchbox">
                                    <div class="select2-search">
                                        <label for="s2id_autogen1_search" class="select2-offscreen">Where is your store based?</label>
                                        <input placeholder="" id="s2id_autogen1_search" aria-owns="select2-results-1" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" type="text">
                                    </div>
                                    <ul id="select2-results-1" class="select2-results" role="listbox"></ul>
                                </div>
                            </div>
                            <select  >
                                <option selected="selected" value="AX">Åland Islands</option>
                                <option value="AF">Afghanistan</option>
                                <option value="AL">Albania</option>
                                <option value="DZ">Algeria</option>
                                <option value="AD">Andorra</option>
                                <option value="AO">Angola</option>
                                <option value="AI">Anguilla</option>
                                <option value="AQ">Antarctica</option>
                                <option value="AG">Antigua and Barbuda</option>

                                <option value="AR:C">Argentina — Ciudad Autónoma de Buenos Aires</option>
                                <option value="AR:B">Argentina — Buenos Aires</option>
                                <option value="AR:K">Argentina — Catamarca</option>
                                <option value="AR:H">Argentina — Chaco</option>
                                <option value="AR:U">Argentina — Chubut</option>
                                <option value="AR:X">Argentina — Córdoba</option>
                                <option value="AR:W">Argentina — Corrientes</option>
                                <option value="AR:E">Argentina — Entre Ríos</option>
                                <option value="AR:P">Argentina — Formosa</option>
                                <option value="AR:Y">Argentina — Jujuy</option>
                                <option value="AR:L">Argentina — La Pampa</option>
                                <option value="AR:F">Argentina — La Rioja</option>
                                <option value="AR:M">Argentina — Mendoza</option>
                                <option value="AR:N">Argentina — Misiones</option>
                                <option value="AR:Q">Argentina — Neuquén</option>
                                <option value="AR:R">Argentina — Río Negro</option>
                                <option value="AR:A">Argentina — Salta</option>
                                <option value="AR:J">Argentina — San Juan</option>
                                <option value="AR:D">Argentina — San Luis</option>
                                <option value="AR:Z">Argentina — Santa Cruz</option>
                                <option value="AR:S">Argentina — Santa Fe</option>
                                <option value="AR:G">Argentina — Santiago del Estero</option>
                                <option value="AR:V">Argentina — Tierra del Fuego</option>
                                <option value="AR:T">Argentina — Tucumán</option>

                                <option value="AM">Armenia</option>
                                <option value="AW">Aruba</option>
                                <option value="AU:ACT">Australia — Australian Capital Territory</option>
                                <option value="AU:NSW">Australia — New South Wales</option>
                                <option value="AU:NT">Australia — Northern Territory</option>
                                <option value="AU:QLD">Australia — Queensland</option>
                                <option value="AU:SA">Australia — South Australia</option>
                                <option value="AU:TAS">Australia — Tasmania</option>
                                <option value="AU:VIC">Australia — Victoria</option>
                                <option value="AU:WA">Australia — Western Australia</option>

                                <option value="AT">Austria</option>
                                <option value="AZ">Azerbaijan</option>
                                <option value="BS">Bahamas</option>
                                <option value="BH">Bahrain</option>

                                <option value="BD:BAG">Bangladesh — Bagerhat</option>
                                <option value="BD:BAN">Bangladesh — Bandarban</option>
                                <option value="BD:BAR">Bangladesh — Barguna</option>
                                <option value="BD:BARI">Bangladesh — Barisal</option>
                                <option value="BD:BHO">Bangladesh — Bhola</option>
                                <option value="BD:BOG">Bangladesh — Bogra</option>
                                <option value="BD:BRA">Bangladesh — Brahmanbaria</option>
                                <option value="BD:CHA">Bangladesh — Chandpur</option>
                                <option value="BD:CHI">Bangladesh — Chittagong</option>
                                <option value="BD:CHU">Bangladesh — Chuadanga</option>
                                <option value="BD:COM">Bangladesh — Comilla</option>
                                <option value="BD:COX">Bangladesh — Cox's Bazar</option>
                                <option value="BD:DHA">Bangladesh — Dhaka</option>
                                <option value="BD:DIN">Bangladesh — Dinajpur</option>
                                <option value="BD:FAR">Bangladesh — Faridpur</option>
                                <option value="BD:FEN">Bangladesh — Feni</option>
                                <option value="BD:GAI">Bangladesh — Gaibandha</option>
                                <option value="BD:GAZI">Bangladesh — Gazipur</option>
                                <option value="BD:GOP">Bangladesh — Gopalganj</option>
                                <option value="BD:HAB">Bangladesh — Habiganj</option>
                                <option value="BD:JAM">Bangladesh — Jamalpur</option>
                                <option value="BD:JES">Bangladesh — Jessore</option>
                                <option value="BD:JHA">Bangladesh — Jhalokati</option>
                                <option value="BD:JHE">Bangladesh — Jhenaidah</option>
                                <option value="BD:JOY">Bangladesh — Joypurhat</option>
                                <option value="BD:KHA">Bangladesh — Khagrachhari</option>
                                <option value="BD:KHU">Bangladesh — Khulna</option>
                                <option value="BD:KIS">Bangladesh — Kishoreganj</option>
                                <option value="BD:KUR">Bangladesh — Kurigram</option>
                                <option value="BD:KUS">Bangladesh — Kushtia</option>
                                <option value="BD:LAK">Bangladesh — Lakshmipur</option>
                                <option value="BD:LAL">Bangladesh — Lalmonirhat</option>
                                <option value="BD:MAD">Bangladesh — Madaripur</option>
                                <option value="BD:MAG">Bangladesh — Magura</option>
                                <option value="BD:MAN">Bangladesh — Manikganj</option>
                                <option value="BD:MEH">Bangladesh — Meherpur</option>
                                <option value="BD:MOU">Bangladesh — Moulvibazar</option>
                                <option value="BD:MUN">Bangladesh — Munshiganj</option>
                                <option value="BD:MYM">Bangladesh — Mymensingh</option>
                                <option value="BD:NAO">Bangladesh — Naogaon</option>
                                <option value="BD:NAR">Bangladesh — Narail</option>
                                <option value="BD:NARG">Bangladesh — Narayanganj</option>
                                <option value="BD:NARD">Bangladesh — Narsingdi</option>
                                <option value="BD:NAT">Bangladesh — Natore</option>
                                <option value="BD:NAW">Bangladesh — Nawabganj</option>
                                <option value="BD:NET">Bangladesh — Netrakona</option>
                                <option value="BD:NIL">Bangladesh — Nilphamari</option>
                                <option value="BD:NOA">Bangladesh — Noakhali</option>
                                <option value="BD:PAB">Bangladesh — Pabna</option>
                                <option value="BD:PAN">Bangladesh — Panchagarh</option>
                                <option value="BD:PAT">Bangladesh — Patuakhali</option>
                                <option value="BD:PIR">Bangladesh — Pirojpur</option>
                                <option value="BD:RAJB">Bangladesh — Rajbari</option>
                                <option value="BD:RAJ">Bangladesh — Rajshahi</option>
                                <option value="BD:RAN">Bangladesh — Rangamati</option>
                                <option value="BD:RANP">Bangladesh — Rangpur</option>
                                <option value="BD:SAT">Bangladesh — Satkhira</option>
                                <option value="BD:SHA">Bangladesh — Shariatpur</option>
                                <option value="BD:SHE">Bangladesh — Sherpur</option>
                                <option value="BD:SIR">Bangladesh — Sirajganj</option>
                                <option value="BD:SUN">Bangladesh — Sunamganj</option>
                                <option value="BD:SYL">Bangladesh — Sylhet</option>
                                <option value="BD:TAN">Bangladesh — Tangail</option>
                                <option value="BD:THA">Bangladesh — Thakurgaon</option>

                                <option value="BB">Barbados</option>
                                <option value="BY">Belarus</option>
                                <option value="PW">Belau</option>
                                <option value="BE">Belgium</option>
                                <option value="BZ">Belize</option>
                                <option value="BJ">Benin</option>
                                <option value="BM">Bermuda</option>
                                <option value="BT">Bhutan</option>
                                <option value="BO">Bolivia</option>
                                <option value="BQ">Bonaire, Saint Eustatius and Saba</option>
                                <option value="BA">Bosnia and Herzegovina</option>
                                <option value="BW">Botswana</option>
                                <option value="BV">Bouvet Island</option>

                                <option value="BR:AC">Brazil — Acre</option>
                                <option value="BR:AL">Brazil — Alagoas</option>
                                <option value="BR:AP">Brazil — Amapá</option>
                                <option value="BR:AM">Brazil — Amazonas</option>
                                <option value="BR:BA">Brazil — Bahia</option>
                                <option value="BR:CE">Brazil — Ceará</option>
                                <option value="BR:DF">Brazil — Distrito Federal</option>
                                <option value="BR:ES">Brazil — Espírito Santo</option>
                                <option value="BR:GO">Brazil — Goiás</option>
                                <option value="BR:MA">Brazil — Maranhão</option>
                                <option value="BR:MT">Brazil — Mato Grosso</option>
                                <option value="BR:MS">Brazil — Mato Grosso do Sul</option>
                                <option value="BR:MG">Brazil — Minas Gerais</option>
                                <option value="BR:PA">Brazil — Pará</option>
                                <option value="BR:PB">Brazil — Paraíba</option>
                                <option value="BR:PR">Brazil — Paraná</option>
                                <option value="BR:PE">Brazil — Pernambuco</option>
                                <option value="BR:PI">Brazil — Piauí</option>
                                <option value="BR:RJ">Brazil — Rio de Janeiro</option>
                                <option value="BR:RN">Brazil — Rio Grande do Norte</option>
                                <option value="BR:RS">Brazil — Rio Grande do Sul</option>
                                <option value="BR:RO">Brazil — Rondônia</option>
                                <option value="BR:RR">Brazil — Roraima</option>
                                <option value="BR:SC">Brazil — Santa Catarina</option>
                                <option value="BR:SP">Brazil — São Paulo</option>
                                <option value="BR:SE">Brazil — Sergipe</option>
                                <option value="BR:TO">Brazil — Tocantins</option>

                                <option value="IO">British Indian Ocean Territory</option>
                                <option value="VG">British Virgin Islands</option>
                                <option value="BN">Brunei</option>

                                <option value="BG:BG-01">Bulgaria — Blagoevgrad</option>
                                <option value="BG:BG-02">Bulgaria — Burgas</option>
                                <option value="BG:BG-08">Bulgaria — Dobrich</option>
                                <option value="BG:BG-07">Bulgaria — Gabrovo</option>
                                <option value="BG:BG-26">Bulgaria — Haskovo</option>
                                <option value="BG:BG-09">Bulgaria — Kardzhali</option>
                                <option value="BG:BG-10">Bulgaria — Kyustendil</option>
                                <option value="BG:BG-11">Bulgaria — Lovech</option>
                                <option value="BG:BG-12">Bulgaria — Montana</option>
                                <option value="BG:BG-13">Bulgaria — Pazardzhik</option>
                                <option value="BG:BG-14">Bulgaria — Pernik</option>
                                <option value="BG:BG-15">Bulgaria — Pleven</option>
                                <option value="BG:BG-16">Bulgaria — Plovdiv</option>
                                <option value="BG:BG-17">Bulgaria — Razgrad</option>
                                <option value="BG:BG-18">Bulgaria — Ruse</option>
                                <option value="BG:BG-27">Bulgaria — Shumen</option>
                                <option value="BG:BG-19">Bulgaria — Silistra</option>
                                <option value="BG:BG-20">Bulgaria — Sliven</option>
                                <option value="BG:BG-21">Bulgaria — Smolyan</option>
                                <option value="BG:BG-23">Bulgaria — Sofia</option>
                                <option value="BG:BG-22">Bulgaria — Sofia-Grad</option>
                                <option value="BG:BG-24">Bulgaria — Stara Zagora</option>
                                <option value="BG:BG-25">Bulgaria — Targovishte</option>
                                <option value="BG:BG-03">Bulgaria — Varna</option>
                                <option value="BG:BG-04">Bulgaria — Veliko Tarnovo</option>
                                <option value="BG:BG-05">Bulgaria — Vidin</option>
                                <option value="BG:BG-06">Bulgaria — Vratsa</option>
                                <option value="BG:BG-28">Bulgaria — Yambol</option>

                                <option value="BF">Burkina Faso</option>
                                <option value="BI">Burundi</option>
                                <option value="KH">Cambodia</option>
                                <option value="CM">Cameroon</option>

                                <option value="CA:AB">Canada — Alberta</option>
                                <option value="CA:BC">Canada — British Columbia</option>
                                <option value="CA:MB">Canada — Manitoba</option>
                                <option value="CA:NB">Canada — New Brunswick</option>
                                <option value="CA:NL">Canada — Newfoundland and Labrador</option>
                                <option value="CA:NT">Canada — Northwest Territories</option>
                                <option value="CA:NS">Canada — Nova Scotia</option>
                                <option value="CA:NU">Canada — Nunavut</option>
                                <option value="CA:ON">Canada — Ontario</option>
                                <option value="CA:PE">Canada — Prince Edward Island</option>
                                <option value="CA:QC">Canada — Quebec</option>
                                <option value="CA:SK">Canada — Saskatchewan</option>
                                <option value="CA:YT">Canada — Yukon Territory</option>

                                <option value="CV">Cape Verde</option>
                                <option value="KY">Cayman Islands</option>
                                <option value="CF">Central African Republic</option>
                                <option value="TD">Chad</option>
                                <option value="CL">Chile</option>

                                <option value="CN:CN1">China — Yunnan / 云南</option>
                                <option value="CN:CN2">China — Beijing / 北京</option>
                                <option value="CN:CN3">China — Tianjin / 天津</option>
                                <option value="CN:CN4">China — Hebei / 河北</option>
                                <option value="CN:CN5">China — Shanxi / 山西</option>
                                <option value="CN:CN6">China — Inner Mongolia / 內蒙古</option>
                                <option value="CN:CN7">China — Liaoning / 辽宁</option>
                                <option value="CN:CN8">China — Jilin / 吉林</option>
                                <option value="CN:CN9">China — Heilongjiang / 黑龙江</option>
                                <option value="CN:CN10">China — Shanghai / 上海</option>
                                <option value="CN:CN11">China — Jiangsu / 江苏</option>
                                <option value="CN:CN12">China — Zhejiang / 浙江</option>
                                <option value="CN:CN13">China — Anhui / 安徽</option>
                                <option value="CN:CN14">China — Fujian / 福建</option>
                                <option value="CN:CN15">China — Jiangxi / 江西</option>
                                <option value="CN:CN16">China — Shandong / 山东</option>
                                <option value="CN:CN17">China — Henan / 河南</option>
                                <option value="CN:CN18">China — Hubei / 湖北</option>
                                <option value="CN:CN19">China — Hunan / 湖南</option>
                                <option value="CN:CN20">China — Guangdong / 广东</option>
                                <option value="CN:CN21">China — Guangxi Zhuang / 广西壮族</option>
                                <option value="CN:CN22">China — Hainan / 海南</option>
                                <option value="CN:CN23">China — Chongqing / 重庆</option>
                                <option value="CN:CN24">China — Sichuan / 四川</option>
                                <option value="CN:CN25">China — Guizhou / 贵州</option>
                                <option value="CN:CN26">China — Shaanxi / 陕西</option>
                                <option value="CN:CN27">China — Gansu / 甘肃</option>
                                <option value="CN:CN28">China — Qinghai / 青海</option>
                                <option value="CN:CN29">China — Ningxia Hui / 宁夏</option>
                                <option value="CN:CN30">China — Macau / 澳门</option>
                                <option value="CN:CN31">China — Tibet / 西藏</option>
                                <option value="CN:CN32">China — Xinjiang / 新疆</option>

                                <option value="CX">Christmas Island</option>
                                <option value="CC">Cocos (Keeling) Islands</option>
                                <option value="CO">Colombia</option>
                                <option value="KM">Comoros</option>
                                <option value="CG">Congo (Brazzaville)</option>
                                <option value="CD">Congo (Kinshasa)</option>
                                <option value="CK">Cook Islands</option>
                                <option value="CR">Costa Rica</option>
                                <option value="HR">Croatia</option>
                                <option value="CU">Cuba</option>
                                <option value="CW">CuraÇao</option>
                                <option value="CY">Cyprus</option>
                                <option value="CZ">Czech Republic</option>
                                <option value="DK">Denmark</option>
                                <option value="DJ">Djibouti</option>
                                <option value="DM">Dominica</option>
                                <option value="DO">Dominican Republic</option>
                                <option value="EC">Ecuador</option>
                                <option value="EG">Egypt</option>
                                <option value="SV">El Salvador</option>
                                <option value="GQ">Equatorial Guinea</option>
                                <option value="ER">Eritrea</option>
                                <option value="EE">Estonia</option>
                                <option value="ET">Ethiopia</option>
                                <option value="FK">Falkland Islands</option>
                                <option value="FO">Faroe Islands</option>
                                <option value="FJ">Fiji</option>
                                <option value="FI">Finland</option>
                                <option value="FR">France</option>
                                <option value="GF">French Guiana</option>
                                <option value="PF">French Polynesia</option>
                                <option value="TF">French Southern Territories</option>
                                <option value="GA">Gabon</option>
                                <option value="GM">Gambia</option>
                                <option value="GE">Georgia</option>
                                <option value="DE">Germany</option>
                                <option value="GH">Ghana</option>
                                <option value="GI">Gibraltar</option>

                                <option value="GR:I">Greece — Αττική</option>
                                <option value="GR:A">Greece — Ανατολική Μακεδονία και Θράκη</option>
                                <option value="GR:B">Greece — Κεντρική Μακεδονία</option>
                                <option value="GR:C">Greece — Δυτική Μακεδονία</option>
                                <option value="GR:D">Greece — Ήπειρος</option>
                                <option value="GR:E">Greece — Θεσσαλία</option>
                                <option value="GR:F">Greece — Ιόνιοι Νήσοι</option>
                                <option value="GR:G">Greece — Δυτική Ελλάδα</option>
                                <option value="GR:H">Greece — Στερεά Ελλάδα</option>
                                <option value="GR:J">Greece — Πελοπόννησος</option>
                                <option value="GR:K">Greece — Βόρειο Αιγαίο</option>
                                <option value="GR:L">Greece — Νότιο Αιγαίο</option>
                                <option value="GR:M">Greece — Κρήτη</option>

                                <option value="GL">Greenland</option>
                                <option value="GD">Grenada</option>
                                <option value="GP">Guadeloupe</option>
                                <option value="GT">Guatemala</option>
                                <option value="GG">Guernsey</option>
                                <option value="GN">Guinea</option>
                                <option value="GW">Guinea-Bissau</option>
                                <option value="GY">Guyana</option>
                                <option value="HT">Haiti</option>
                                <option value="HM">Heard Island and McDonald Islands</option>
                                <option value="HN">Honduras</option>

                                <option value="HK:HONG KONG">Hong Kong — Hong Kong Island</option>
                                <option value="HK:KOWLOON">Hong Kong — Kowloon</option>
                                <option value="HK:NEW TERRITORIES">Hong Kong — New Territories</option>

                                <option value="HU:BK">Hungary — Bács-Kiskun</option>
                                <option value="HU:BE">Hungary — Békés</option>
                                <option value="HU:BA">Hungary — Baranya</option>
                                <option value="HU:BZ">Hungary — Borsod-Abaúj-Zemplén</option>
                                <option value="HU:BU">Hungary — Budapest</option>
                                <option value="HU:CS">Hungary — Csongrád</option>
                                <option value="HU:FE">Hungary — Fejér</option>
                                <option value="HU:GS">Hungary — Győr-Moson-Sopron</option>
                                <option value="HU:HB">Hungary — Hajdú-Bihar</option>
                                <option value="HU:HE">Hungary — Heves</option>
                                <option value="HU:JN">Hungary — Jász-Nagykun-Szolnok</option>
                                <option value="HU:KE">Hungary — Komárom-Esztergom</option>
                                <option value="HU:NO">Hungary — Nógrád</option>
                                <option value="HU:PE">Hungary — Pest</option>
                                <option value="HU:SO">Hungary — Somogy</option>
                                <option value="HU:SZ">Hungary — Szabolcs-Szatmár-Bereg</option>
                                <option value="HU:TO">Hungary — Tolna</option>
                                <option value="HU:VA">Hungary — Vas</option>
                                <option value="HU:VE">Hungary — Veszprém</option>
                                <option value="HU:ZA">Hungary — Zala</option>

                                <option value="IS">Iceland</option>

                                <option value="IN:AP">India — Andhra Pradesh</option>
                                <option value="IN:AR">India — Arunachal Pradesh</option>
                                <option value="IN:AS">India — Assam</option>
                                <option value="IN:BR">India — Bihar</option>
                                <option value="IN:CT">India — Chhattisgarh</option>
                                <option value="IN:GA">India — Goa</option>
                                <option value="IN:GJ">India — Gujarat</option>
                                <option value="IN:HR">India — Haryana</option>
                                <option value="IN:HP">India — Himachal Pradesh</option>
                                <option value="IN:JK">India — Jammu and Kashmir</option>
                                <option value="IN:JH">India — Jharkhand</option>
                                <option value="IN:KA">India — Karnataka</option>
                                <option value="IN:KL">India — Kerala</option>
                                <option value="IN:MP">India — Madhya Pradesh</option>
                                <option value="IN:MH">India — Maharashtra</option>
                                <option value="IN:MN">India — Manipur</option>
                                <option value="IN:ML">India — Meghalaya</option>
                                <option value="IN:MZ">India — Mizoram</option>
                                <option value="IN:NL">India — Nagaland</option>
                                <option value="IN:OR">India — Orissa</option>
                                <option value="IN:PB">India — Punjab</option>
                                <option value="IN:RJ">India — Rajasthan</option>
                                <option value="IN:SK">India — Sikkim</option>
                                <option value="IN:TN">India — Tamil Nadu</option>
                                <option value="IN:TS">India — Telangana</option>
                                <option value="IN:TR">India — Tripura</option>
                                <option value="IN:UK">India — Uttarakhand</option>
                                <option value="IN:UP">India — Uttar Pradesh</option>
                                <option value="IN:WB">India — West Bengal</option>
                                <option value="IN:AN">India — Andaman and Nicobar Islands</option>
                                <option value="IN:CH">India — Chandigarh</option>
                                <option value="IN:DN">India — Dadar and Nagar Haveli</option>
                                <option value="IN:DD">India — Daman and Diu</option>
                                <option value="IN:DL">India — Delhi</option>
                                <option value="IN:LD">India — Lakshadeep</option>
                                <option value="IN:PY">India — Pondicherry (Puducherry)</option>

                                <option value="ID:AC">Indonesia — Daerah Istimewa Aceh</option>
                                <option value="ID:SU">Indonesia — Sumatera Utara</option>
                                <option value="ID:SB">Indonesia — Sumatera Barat</option>
                                <option value="ID:RI">Indonesia — Riau</option>
                                <option value="ID:KR">Indonesia — Kepulauan Riau</option>
                                <option value="ID:JA">Indonesia — Jambi</option>
                                <option value="ID:SS">Indonesia — Sumatera Selatan</option>
                                <option value="ID:BB">Indonesia — Bangka Belitung</option>
                                <option value="ID:BE">Indonesia — Bengkulu</option>
                                <option value="ID:LA">Indonesia — Lampung</option>
                                <option value="ID:JK">Indonesia — DKI Jakarta</option>
                                <option value="ID:JB">Indonesia — Jawa Barat</option>
                                <option value="ID:BT">Indonesia — Banten</option>
                                <option value="ID:JT">Indonesia — Jawa Tengah</option>
                                <option value="ID:JI">Indonesia — Jawa Timur</option>
                                <option value="ID:YO">Indonesia — Daerah Istimewa Yogyakarta</option>
                                <option value="ID:BA">Indonesia — Bali</option>
                                <option value="ID:NB">Indonesia — Nusa Tenggara Barat</option>
                                <option value="ID:NT">Indonesia — Nusa Tenggara Timur</option>
                                <option value="ID:KB">Indonesia — Kalimantan Barat</option>
                                <option value="ID:KT">Indonesia — Kalimantan Tengah</option>
                                <option value="ID:KI">Indonesia — Kalimantan Timur</option>
                                <option value="ID:KS">Indonesia — Kalimantan Selatan</option>
                                <option value="ID:KU">Indonesia — Kalimantan Utara</option>
                                <option value="ID:SA">Indonesia — Sulawesi Utara</option>
                                <option value="ID:ST">Indonesia — Sulawesi Tengah</option>
                                <option value="ID:SG">Indonesia — Sulawesi Tenggara</option>
                                <option value="ID:SR">Indonesia — Sulawesi Barat</option>
                                <option value="ID:SN">Indonesia — Sulawesi Selatan</option>
                                <option value="ID:GO">Indonesia — Gorontalo</option>
                                <option value="ID:MA">Indonesia — Maluku</option>
                                <option value="ID:MU">Indonesia — Maluku Utara</option>
                                <option value="ID:PA">Indonesia — Papua</option>
                                <option value="ID:PB">Indonesia — Papua Barat</option>

                                <option value="IR:KHZ">Iran — Khuzestan (خوزستان)</option>
                                <option value="IR:THR">Iran — Tehran (تهران)</option>
                                <option value="IR:ILM">Iran — Ilaam (ایلام)</option>
                                <option value="IR:BHR">Iran — Bushehr (بوشهر)</option>
                                <option value="IR:ADL">Iran — Ardabil (اردبیل)</option>
                                <option value="IR:ESF">Iran — Isfahan (اصفهان)</option>
                                <option value="IR:YZD">Iran — Yazd (یزد)</option>
                                <option value="IR:KRH">Iran — Kermanshah (کرمانشاه)</option>
                                <option value="IR:KRN">Iran — Kerman (کرمان)</option>
                                <option value="IR:HDN">Iran — Hamadan (همدان)</option>
                                <option value="IR:GZN">Iran — Ghazvin (قزوین)</option>
                                <option value="IR:ZJN">Iran — Zanjan (زنجان)</option>
                                <option value="IR:LRS">Iran — Luristan (لرستان)</option>
                                <option value="IR:ABZ">Iran — Alborz (البرز)</option>
                                <option value="IR:EAZ">Iran — East Azarbaijan (آذربایجان شرقی)</option>
                                <option value="IR:WAZ">Iran — West Azarbaijan (آذربایجان غربی)</option>
                                <option value="IR:CHB">Iran — Chaharmahal and Bakhtiari (چهارمحال و بختیاری)</option>
                                <option value="IR:SKH">Iran — South Khorasan (خراسان جنوبی)</option>
                                <option value="IR:RKH">Iran — Razavi Khorasan (خراسان رضوی)</option>
                                <option value="IR:NKH">Iran — North Khorasan (خراسان جنوبی)</option>
                                <option value="IR:SMN">Iran — Semnan (سمنان)</option>
                                <option value="IR:FRS">Iran — Fars (فارس)</option>
                                <option value="IR:QHM">Iran — Qom (قم)</option>
                                <option value="IR:KRD">Iran — Kurdistan / کردستان)</option>
                                <option value="IR:KBD">Iran — Kohgiluyeh and BoyerAhmad (کهگیلوییه و بویراحمد)</option>
                                <option value="IR:GLS">Iran — Golestan (گلستان)</option>
                                <option value="IR:GIL">Iran — Gilan (گیلان)</option>
                                <option value="IR:MZN">Iran — Mazandaran (مازندران)</option>
                                <option value="IR:MKZ">Iran — Markazi (مرکزی)</option>
                                <option value="IR:HRZ">Iran — Hormozgan (هرمزگان)</option>
                                <option value="IR:SBN">Iran — Sistan and Baluchestan (سیستان و بلوچستان)</option>

                                <option value="IQ">Iraq</option>
                                <option value="IM">Isle of Man</option>
                                <option value="IL">Israel</option>

                                <option value="IT:AG">Italy — Agrigento</option>
                                <option value="IT:AL">Italy — Alessandria</option>
                                <option value="IT:AN">Italy — Ancona</option>
                                <option value="IT:AO">Italy — Aosta</option>
                                <option value="IT:AR">Italy — Arezzo</option>
                                <option value="IT:AP">Italy — Ascoli Piceno</option>
                                <option value="IT:AT">Italy — Asti</option>
                                <option value="IT:AV">Italy — Avellino</option>
                                <option value="IT:BA">Italy — Bari</option>
                                <option value="IT:BT">Italy — Barletta-Andria-Trani</option>
                                <option value="IT:BL">Italy — Belluno</option>
                                <option value="IT:BN">Italy — Benevento</option>
                                <option value="IT:BG">Italy — Bergamo</option>
                                <option value="IT:BI">Italy — Biella</option>
                                <option value="IT:BO">Italy — Bologna</option>
                                <option value="IT:BZ">Italy — Bolzano</option>
                                <option value="IT:BS">Italy — Brescia</option>
                                <option value="IT:BR">Italy — Brindisi</option>
                                <option value="IT:CA">Italy — Cagliari</option>
                                <option value="IT:CL">Italy — Caltanissetta</option>
                                <option value="IT:CB">Italy — Campobasso</option>
                                <option value="IT:CI">Italy — Carbonia-Iglesias</option>
                                <option value="IT:CE">Italy — Caserta</option>
                                <option value="IT:CT">Italy — Catania</option>
                                <option value="IT:CZ">Italy — Catanzaro</option>
                                <option value="IT:CH">Italy — Chieti</option>
                                <option value="IT:CO">Italy — Como</option>
                                <option value="IT:CS">Italy — Cosenza</option>
                                <option value="IT:CR">Italy — Cremona</option>
                                <option value="IT:KR">Italy — Crotone</option>
                                <option value="IT:CN">Italy — Cuneo</option>
                                <option value="IT:EN">Italy — Enna</option>
                                <option value="IT:FM">Italy — Fermo</option>
                                <option value="IT:FE">Italy — Ferrara</option>
                                <option value="IT:FI">Italy — Firenze</option>
                                <option value="IT:FG">Italy — Foggia</option>
                                <option value="IT:FC">Italy — Forlì-Cesena</option>
                                <option value="IT:FR">Italy — Frosinone</option>
                                <option value="IT:GE">Italy — Genova</option>
                                <option value="IT:GO">Italy — Gorizia</option>
                                <option value="IT:GR">Italy — Grosseto</option>
                                <option value="IT:IM">Italy — Imperia</option>
                                <option value="IT:IS">Italy — Isernia</option>
                                <option value="IT:SP">Italy — La Spezia</option>
                                <option value="IT:AQ">Italy — L'Aquila</option>
                                <option value="IT:LT">Italy — Latina</option>
                                <option value="IT:LE">Italy — Lecce</option>
                                <option value="IT:LC">Italy — Lecco</option>
                                <option value="IT:LI">Italy — Livorno</option>
                                <option value="IT:LO">Italy — Lodi</option>
                                <option value="IT:LU">Italy — Lucca</option>
                                <option value="IT:MC">Italy — Macerata</option>
                                <option value="IT:MN">Italy — Mantova</option>
                                <option value="IT:MS">Italy — Massa-Carrara</option>
                                <option value="IT:MT">Italy — Matera</option>
                                <option value="IT:ME">Italy — Messina</option>
                                <option value="IT:MI">Italy — Milano</option>
                                <option value="IT:MO">Italy — Modena</option>
                                <option value="IT:MB">Italy — Monza e della Brianza</option>
                                <option value="IT:NA">Italy — Napoli</option>
                                <option value="IT:NO">Italy — Novara</option>
                                <option value="IT:NU">Italy — Nuoro</option>
                                <option value="IT:OT">Italy — Olbia-Tempio</option>
                                <option value="IT:OR">Italy — Oristano</option>
                                <option value="IT:PD">Italy — Padova</option>
                                <option value="IT:PA">Italy — Palermo</option>
                                <option value="IT:PR">Italy — Parma</option>
                                <option value="IT:PV">Italy — Pavia</option>
                                <option value="IT:PG">Italy — Perugia</option>
                                <option value="IT:PU">Italy — Pesaro e Urbino</option>
                                <option value="IT:PE">Italy — Pescara</option>
                                <option value="IT:PC">Italy — Piacenza</option>
                                <option value="IT:PI">Italy — Pisa</option>
                                <option value="IT:PT">Italy — Pistoia</option>
                                <option value="IT:PN">Italy — Pordenone</option>
                                <option value="IT:PZ">Italy — Potenza</option>
                                <option value="IT:PO">Italy — Prato</option>
                                <option value="IT:RG">Italy — Ragusa</option>
                                <option value="IT:RA">Italy — Ravenna</option>
                                <option value="IT:RC">Italy — Reggio Calabria</option>
                                <option value="IT:RE">Italy — Reggio Emilia</option>
                                <option value="IT:RI">Italy — Rieti</option>
                                <option value="IT:RN">Italy — Rimini</option>
                                <option value="IT:RM">Italy — Roma</option>
                                <option value="IT:RO">Italy — Rovigo</option>
                                <option value="IT:SA">Italy — Salerno</option>
                                <option value="IT:VS">Italy — Medio Campidano</option>
                                <option value="IT:SS">Italy — Sassari</option>
                                <option value="IT:SV">Italy — Savona</option>
                                <option value="IT:SI">Italy — Siena</option>
                                <option value="IT:SR">Italy — Siracusa</option>
                                <option value="IT:SO">Italy — Sondrio</option>
                                <option value="IT:TA">Italy — Taranto</option>
                                <option value="IT:TE">Italy — Teramo</option>
                                <option value="IT:TR">Italy — Terni</option>
                                <option value="IT:TO">Italy — Torino</option>
                                <option value="IT:OG">Italy — Ogliastra</option>
                                <option value="IT:TP">Italy — Trapani</option>
                                <option value="IT:TN">Italy — Trento</option>
                                <option value="IT:TV">Italy — Treviso</option>
                                <option value="IT:TS">Italy — Trieste</option>
                                <option value="IT:UD">Italy — Udine</option>
                                <option value="IT:VA">Italy — Varese</option>
                                <option value="IT:VE">Italy — Venezia</option>
                                <option value="IT:VB">Italy — Verbano-Cusio-Ossola</option>
                                <option value="IT:VC">Italy — Vercelli</option>
                                <option value="IT:VR">Italy — Verona</option>
                                <option value="IT:VV">Italy — Vibo Valentia</option>
                                <option value="IT:VI">Italy — Vicenza</option>
                                <option value="IT:VT">Italy — Viterbo</option>

                                <option value="CI">Ivory Coast</option>
                                <option value="JM">Jamaica</option>

                                <option value="JP:JP01">Japan — Hokkaido</option>
                                <option value="JP:JP02">Japan — Aomori</option>
                                <option value="JP:JP03">Japan — Iwate</option>
                                <option value="JP:JP04">Japan — Miyagi</option>
                                <option value="JP:JP05">Japan — Akita</option>
                                <option value="JP:JP06">Japan — Yamagata</option>
                                <option value="JP:JP07">Japan — Fukushima</option>
                                <option value="JP:JP08">Japan — Ibaraki</option>
                                <option value="JP:JP09">Japan — Tochigi</option>
                                <option value="JP:JP10">Japan — Gunma</option>
                                <option value="JP:JP11">Japan — Saitama</option>
                                <option value="JP:JP12">Japan — Chiba</option>
                                <option value="JP:JP13">Japan — Tokyo</option>
                                <option value="JP:JP14">Japan — Kanagawa</option>
                                <option value="JP:JP15">Japan — Niigata</option>
                                <option value="JP:JP16">Japan — Toyama</option>
                                <option value="JP:JP17">Japan — Ishikawa</option>
                                <option value="JP:JP18">Japan — Fukui</option>
                                <option value="JP:JP19">Japan — Yamanashi</option>
                                <option value="JP:JP20">Japan — Nagano</option>
                                <option value="JP:JP21">Japan — Gifu</option>
                                <option value="JP:JP22">Japan — Shizuoka</option>
                                <option value="JP:JP23">Japan — Aichi</option>
                                <option value="JP:JP24">Japan — Mie</option>
                                <option value="JP:JP25">Japan — Shiga</option>
                                <option value="JP:JP26">Japan — Kyoto</option>
                                <option value="JP:JP27">Japan — Osaka</option>
                                <option value="JP:JP28">Japan — Hyogo</option>
                                <option value="JP:JP29">Japan — Nara</option>
                                <option value="JP:JP30">Japan — Wakayama</option>
                                <option value="JP:JP31">Japan — Tottori</option>
                                <option value="JP:JP32">Japan — Shimane</option>
                                <option value="JP:JP33">Japan — Okayama</option>
                                <option value="JP:JP34">Japan — Hiroshima</option>
                                <option value="JP:JP35">Japan — Yamaguchi</option>
                                <option value="JP:JP36">Japan — Tokushima</option>
                                <option value="JP:JP37">Japan — Kagawa</option>
                                <option value="JP:JP38">Japan — Ehime</option>
                                <option value="JP:JP39">Japan — Kochi</option>
                                <option value="JP:JP40">Japan — Fukuoka</option>
                                <option value="JP:JP41">Japan — Saga</option>
                                <option value="JP:JP42">Japan — Nagasaki</option>
                                <option value="JP:JP43">Japan — Kumamoto</option>
                                <option value="JP:JP44">Japan — Oita</option>
                                <option value="JP:JP45">Japan — Miyazaki</option>
                                <option value="JP:JP46">Japan — Kagoshima</option>
                                <option value="JP:JP47">Japan — Okinawa</option>

                                <option value="JE">Jersey</option>
                                <option value="JO">Jordan</option>
                                <option value="KZ">Kazakhstan</option>
                                <option value="KE">Kenya</option>
                                <option value="KI">Kiribati</option>
                                <option value="KW">Kuwait</option>
                                <option value="KG">Kyrgyzstan</option>
                                <option value="LA">Laos</option>
                                <option value="LV">Latvia</option>
                                <option value="LB">Lebanon</option>
                                <option value="LS">Lesotho</option>
                                <option value="LR">Liberia</option>
                                <option value="LY">Libya</option>
                                <option value="LI">Liechtenstein</option>
                                <option value="LT">Lithuania</option>
                                <option value="LU">Luxembourg</option>
                                <option value="MO">Macao S.A.R., China</option>
                                <option value="MK">Macedonia</option>
                                <option value="MG">Madagascar</option>
                                <option value="MW">Malawi</option>
                                <optgroup label="Malaysia">
                                    <option value="MY:JHR">Malaysia — Johor</option>
                                    <option value="MY:KDH">Malaysia — Kedah</option>
                                    <option value="MY:KTN">Malaysia — Kelantan</option>
                                    <option value="MY:MLK">Malaysia — Melaka</option>
                                    <option value="MY:NSN">Malaysia — Negeri Sembilan</option>
                                    <option value="MY:PHG">Malaysia — Pahang</option>
                                    <option value="MY:PRK">Malaysia — Perak</option>
                                    <option value="MY:PLS">Malaysia — Perlis</option>
                                    <option value="MY:PNG">Malaysia — Pulau Pinang</option>
                                    <option value="MY:SBH">Malaysia — Sabah</option>
                                    <option value="MY:SWK">Malaysia — Sarawak</option>
                                    <option value="MY:SGR">Malaysia — Selangor</option>
                                    <option value="MY:TRG">Malaysia — Terengganu</option>
                                    <option value="MY:KUL">Malaysia — W.P. Kuala Lumpur</option>
                                    <option value="MY:LBN">Malaysia — W.P. Labuan</option>
                                    <option value="MY:PJY">Malaysia — W.P. Putrajaya</option>

                                    <option value="MV">Maldives</option>
                                    <option value="ML">Mali</option>
                                    <option value="MT">Malta</option>
                                    <option value="MH">Marshall Islands</option>
                                    <option value="MQ">Martinique</option>
                                    <option value="MR">Mauritania</option>
                                    <option value="MU">Mauritius</option>
                                    <option value="YT">Mayotte</option>

                                    <option value="MX:Distrito Federal">Mexico — Distrito Federal</option>
                                    <option value="MX:Jalisco">Mexico — Jalisco</option>
                                    <option value="MX:Nuevo Leon">Mexico — Nuevo León</option>
                                    <option value="MX:Aguascalientes">Mexico — Aguascalientes</option>
                                    <option value="MX:Baja California">Mexico — Baja California</option>
                                    <option value="MX:Baja California Sur">Mexico — Baja California Sur</option>
                                    <option value="MX:Campeche">Mexico — Campeche</option>
                                    <option value="MX:Chiapas">Mexico — Chiapas</option>
                                    <option value="MX:Chihuahua">Mexico — Chihuahua</option>
                                    <option value="MX:Coahuila">Mexico — Coahuila</option>
                                    <option value="MX:Colima">Mexico — Colima</option>
                                    <option value="MX:Durango">Mexico — Durango</option>
                                    <option value="MX:Guanajuato">Mexico — Guanajuato</option>
                                    <option value="MX:Guerrero">Mexico — Guerrero</option>
                                    <option value="MX:Hidalgo">Mexico — Hidalgo</option>
                                    <option value="MX:Estado de Mexico">Mexico — Edo. de México</option>
                                    <option value="MX:Michoacan">Mexico — Michoacán</option>
                                    <option value="MX:Morelos">Mexico — Morelos</option>
                                    <option value="MX:Nayarit">Mexico — Nayarit</option>
                                    <option value="MX:Oaxaca">Mexico — Oaxaca</option>
                                    <option value="MX:Puebla">Mexico — Puebla</option>
                                    <option value="MX:Queretaro">Mexico — Querétaro</option>
                                    <option value="MX:Quintana Roo">Mexico — Quintana Roo</option>
                                    <option value="MX:San Luis Potosi">Mexico — San Luis Potosí</option>
                                    <option value="MX:Sinaloa">Mexico — Sinaloa</option>
                                    <option value="MX:Sonora">Mexico — Sonora</option>
                                    <option value="MX:Tabasco">Mexico — Tabasco</option>
                                    <option value="MX:Tamaulipas">Mexico — Tamaulipas</option>
                                    <option value="MX:Tlaxcala">Mexico — Tlaxcala</option>
                                    <option value="MX:Veracruz">Mexico — Veracruz</option>
                                    <option value="MX:Yucatan">Mexico — Yucatán</option>
                                    <option value="MX:Zacatecas">Mexico — Zacatecas</option>

                                    <option value="FM">Micronesia</option>
                                    <option value="MD">Moldova</option>
                                    <option value="MC">Monaco</option>
                                    <option value="MN">Mongolia</option>
                                    <option value="ME">Montenegro</option>
                                    <option value="MS">Montserrat</option>
                                    <option value="MA">Morocco</option>
                                    <option value="MZ">Mozambique</option>
                                    <option value="MM">Myanmar</option>
                                    <option value="NA">Namibia</option>
                                    <option value="NR">Nauru</option>

                                    <option value="NP:ILL">Nepal — Illam</option>
                                    <option value="NP:JHA">Nepal — Jhapa</option>
                                    <option value="NP:PAN">Nepal — Panchthar</option>
                                    <option value="NP:TAP">Nepal — Taplejung</option>
                                    <option value="NP:BHO">Nepal — Bhojpur</option>
                                    <option value="NP:DKA">Nepal — Dhankuta</option>
                                    <option value="NP:MOR">Nepal — Morang</option>
                                    <option value="NP:SUN">Nepal — Sunsari</option>
                                    <option value="NP:SAN">Nepal — Sankhuwa</option>
                                    <option value="NP:TER">Nepal — Terhathum</option>
                                    <option value="NP:KHO">Nepal — Khotang</option>
                                    <option value="NP:OKH">Nepal — Okhaldhunga</option>
                                    <option value="NP:SAP">Nepal — Saptari</option>
                                    <option value="NP:SIR">Nepal — Siraha</option>
                                    <option value="NP:SOL">Nepal — Solukhumbu</option>
                                    <option value="NP:UDA">Nepal — Udayapur</option>
                                    <option value="NP:DHA">Nepal — Dhanusa</option>
                                    <option value="NP:DLK">Nepal — Dolakha</option>
                                    <option value="NP:MOH">Nepal — Mohottari</option>
                                    <option value="NP:RAM">Nepal — Ramechha</option>
                                    <option value="NP:SAR">Nepal — Sarlahi</option>
                                    <option value="NP:SIN">Nepal — Sindhuli</option>
                                    <option value="NP:BHA">Nepal — Bhaktapur</option>
                                    <option value="NP:DHD">Nepal — Dhading</option>
                                    <option value="NP:KTM">Nepal — Kathmandu</option>
                                    <option value="NP:KAV">Nepal — Kavrepalanchowk</option>
                                    <option value="NP:LAL">Nepal — Lalitpur</option>
                                    <option value="NP:NUW">Nepal — Nuwakot</option>
                                    <option value="NP:RAS">Nepal — Rasuwa</option>
                                    <option value="NP:SPC">Nepal — Sindhupalchowk</option>
                                    <option value="NP:BAR">Nepal — Bara</option>
                                    <option value="NP:CHI">Nepal — Chitwan</option>
                                    <option value="NP:MAK">Nepal — Makwanpur</option>
                                    <option value="NP:PAR">Nepal — Parsa</option>
                                    <option value="NP:RAU">Nepal — Rautahat</option>
                                    <option value="NP:GOR">Nepal — Gorkha</option>
                                    <option value="NP:KAS">Nepal — Kaski</option>
                                    <option value="NP:LAM">Nepal — Lamjung</option>
                                    <option value="NP:MAN">Nepal — Manang</option>
                                    <option value="NP:SYN">Nepal — Syangja</option>
                                    <option value="NP:TAN">Nepal — Tanahun</option>
                                    <option value="NP:BAG">Nepal — Baglung</option>
                                    <option value="NP:PBT">Nepal — Parbat</option>
                                    <option value="NP:MUS">Nepal — Mustang</option>
                                    <option value="NP:MYG">Nepal — Myagdi</option>
                                    <option value="NP:AGR">Nepal — Agrghakanchi</option>
                                    <option value="NP:GUL">Nepal — Gulmi</option>
                                    <option value="NP:KAP">Nepal — Kapilbastu</option>
                                    <option value="NP:NAW">Nepal — Nawalparasi</option>
                                    <option value="NP:PAL">Nepal — Palpa</option>
                                    <option value="NP:RUP">Nepal — Rupandehi</option>
                                    <option value="NP:DAN">Nepal — Dang</option>
                                    <option value="NP:PYU">Nepal — Pyuthan</option>
                                    <option value="NP:ROL">Nepal — Rolpa</option>
                                    <option value="NP:RUK">Nepal — Rukum</option>
                                    <option value="NP:SAL">Nepal — Salyan</option>
                                    <option value="NP:BAN">Nepal — Banke</option>
                                    <option value="NP:BDA">Nepal — Bardiya</option>
                                    <option value="NP:DAI">Nepal — Dailekh</option>
                                    <option value="NP:JAJ">Nepal — Jajarkot</option>
                                    <option value="NP:SUR">Nepal — Surkhet</option>
                                    <option value="NP:DOL">Nepal — Dolpa</option>
                                    <option value="NP:HUM">Nepal — Humla</option>
                                    <option value="NP:JUM">Nepal — Jumla</option>
                                    <option value="NP:KAL">Nepal — Kalikot</option>
                                    <option value="NP:MUG">Nepal — Mugu</option>
                                    <option value="NP:ACH">Nepal — Achham</option>
                                    <option value="NP:BJH">Nepal — Bajhang</option>
                                    <option value="NP:BJU">Nepal — Bajura</option>
                                    <option value="NP:DOT">Nepal — Doti</option>
                                    <option value="NP:KAI">Nepal — Kailali</option>
                                    <option value="NP:BAI">Nepal — Baitadi</option>
                                    <option value="NP:DAD">Nepal — Dadeldhura</option>
                                    <option value="NP:DAR">Nepal — Darchula</option>
                                    <option value="NP:KAN">Nepal — Kanchanpur</option>

                                    <option value="NL">Netherlands</option>
                                    <option value="AN">Netherlands Antilles</option>
                                    <option value="NC">New Caledonia</option>

                                    <option value="NZ:NL">New Zealand — Northland</option>
                                    <option value="NZ:AK">New Zealand — Auckland</option>
                                    <option value="NZ:WA">New Zealand — Waikato</option>
                                    <option value="NZ:BP">New Zealand — Bay of Plenty</option>
                                    <option value="NZ:TK">New Zealand — Taranaki</option>
                                    <option value="NZ:GI">New Zealand — Gisborne</option>
                                    <option value="NZ:HB">New Zealand — Hawke’s Bay</option>
                                    <option value="NZ:MW">New Zealand — Manawatu-Wanganui</option>
                                    <option value="NZ:WE">New Zealand — Wellington</option>
                                    <option value="NZ:NS">New Zealand — Nelson</option>
                                    <option value="NZ:MB">New Zealand — Marlborough</option>
                                    <option value="NZ:TM">New Zealand — Tasman</option>
                                    <option value="NZ:WC">New Zealand — West Coast</option>
                                    <option value="NZ:CT">New Zealand — Canterbury</option>
                                    <option value="NZ:OT">New Zealand — Otago</option>
                                    <option value="NZ:SL">New Zealand — Southland</option>

                                    <option value="NI">Nicaragua</option>
                                    <option value="NE">Niger</option>
                                    <option value="NG">Nigeria</option>
                                    <option value="NU">Niue</option>
                                    <option value="NF">Norfolk Island</option>
                                    <option value="KP">North Korea</option>
                                    <option value="NO">Norway</option>
                                    <option value="OM">Oman</option>
                                    <option value="PK">Pakistan</option>
                                    <option value="PS">Palestinian Territory</option>
                                    <option value="PA">Panama</option>
                                    <option value="PG">Papua New Guinea</option>
                                    <option value="PY">Paraguay</option>

                                    <option value="PE:CAL">Peru — El Callao</option>
                                    <option value="PE:LMA">Peru — Municipalidad Metropolitana de Lima</option>
                                    <option value="PE:AMA">Peru — Amazonas</option>
                                    <option value="PE:ANC">Peru — Ancash</option>
                                    <option value="PE:APU">Peru — Apurímac</option>
                                    <option value="PE:ARE">Peru — Arequipa</option>
                                    <option value="PE:AYA">Peru — Ayacucho</option>
                                    <option value="PE:CAJ">Peru — Cajamarca</option>
                                    <option value="PE:CUS">Peru — Cusco</option>
                                    <option value="PE:HUV">Peru — Huancavelica</option>
                                    <option value="PE:HUC">Peru — Huánuco</option>
                                    <option value="PE:ICA">Peru — Ica</option>
                                    <option value="PE:JUN">Peru — Junín</option>
                                    <option value="PE:LAL">Peru — La Libertad</option>
                                    <option value="PE:LAM">Peru — Lambayeque</option>
                                    <option value="PE:LIM">Peru — Lima</option>
                                    <option value="PE:LOR">Peru — Loreto</option>
                                    <option value="PE:MDD">Peru — Madre de Dios</option>
                                    <option value="PE:MOQ">Peru — Moquegua</option>
                                    <option value="PE:PAS">Peru — Pasco</option>
                                    <option value="PE:PIU">Peru — Piura</option>
                                    <option value="PE:PUN">Peru — Puno</option>
                                    <option value="PE:SAM">Peru — San Martín</option>
                                    <option value="PE:TAC">Peru — Tacna</option>
                                    <option value="PE:TUM">Peru — Tumbes</option>
                                    <option value="PE:UCA">Peru — Ucayali</option>

                                    <option value="PH:ABR">Philippines — Abra</option>
                                    <option value="PH:AGN">Philippines — Agusan del Norte</option>
                                    <option value="PH:AGS">Philippines — Agusan del Sur</option>
                                    <option value="PH:AKL">Philippines — Aklan</option>
                                    <option value="PH:ALB">Philippines — Albay</option>
                                    <option value="PH:ANT">Philippines — Antique</option>
                                    <option value="PH:APA">Philippines — Apayao</option>
                                    <option value="PH:AUR">Philippines — Aurora</option>
                                    <option value="PH:BAS">Philippines — Basilan</option>
                                    <option value="PH:BAN">Philippines — Bataan</option>
                                    <option value="PH:BTN">Philippines — Batanes</option>
                                    <option value="PH:BTG">Philippines — Batangas</option>
                                    <option value="PH:BEN">Philippines — Benguet</option>
                                    <option value="PH:BIL">Philippines — Biliran</option>
                                    <option value="PH:BOH">Philippines — Bohol</option>
                                    <option value="PH:BUK">Philippines — Bukidnon</option>
                                    <option value="PH:BUL">Philippines — Bulacan</option>
                                    <option value="PH:CAG">Philippines — Cagayan</option>
                                    <option value="PH:CAN">Philippines — Camarines Norte</option>
                                    <option value="PH:CAS">Philippines — Camarines Sur</option>
                                    <option value="PH:CAM">Philippines — Camiguin</option>
                                    <option value="PH:CAP">Philippines — Capiz</option>
                                    <option value="PH:CAT">Philippines — Catanduanes</option>
                                    <option value="PH:CAV">Philippines — Cavite</option>
                                    <option value="PH:CEB">Philippines — Cebu</option>
                                    <option value="PH:COM">Philippines — Compostela Valley</option>
                                    <option value="PH:NCO">Philippines — Cotabato</option>
                                    <option value="PH:DAV">Philippines — Davao del Norte</option>
                                    <option value="PH:DAS">Philippines — Davao del Sur</option>
                                    <option value="PH:DAC">Philippines — Davao Occidental</option>
                                    <option value="PH:DAO">Philippines — Davao Oriental</option>
                                    <option value="PH:DIN">Philippines — Dinagat Islands</option>
                                    <option value="PH:EAS">Philippines — Eastern Samar</option>
                                    <option value="PH:GUI">Philippines — Guimaras</option>
                                    <option value="PH:IFU">Philippines — Ifugao</option>
                                    <option value="PH:ILN">Philippines — Ilocos Norte</option>
                                    <option value="PH:ILS">Philippines — Ilocos Sur</option>
                                    <option value="PH:ILI">Philippines — Iloilo</option>
                                    <option value="PH:ISA">Philippines — Isabela</option>
                                    <option value="PH:KAL">Philippines — Kalinga</option>
                                    <option value="PH:LUN">Philippines — La Union</option>
                                    <option value="PH:LAG">Philippines — Laguna</option>
                                    <option value="PH:LAN">Philippines — Lanao del Norte</option>
                                    <option value="PH:LAS">Philippines — Lanao del Sur</option>
                                    <option value="PH:LEY">Philippines — Leyte</option>
                                    <option value="PH:MAG">Philippines — Maguindanao</option>
                                    <option value="PH:MAD">Philippines — Marinduque</option>
                                    <option value="PH:MAS">Philippines — Masbate</option>
                                    <option value="PH:MSC">Philippines — Misamis Occidental</option>
                                    <option value="PH:MSR">Philippines — Misamis Oriental</option>
                                    <option value="PH:MOU">Philippines — Mountain Province</option>
                                    <option value="PH:NEC">Philippines — Negros Occidental</option>
                                    <option value="PH:NER">Philippines — Negros Oriental</option>
                                    <option value="PH:NSA">Philippines — Northern Samar</option>
                                    <option value="PH:NUE">Philippines — Nueva Ecija</option>
                                    <option value="PH:NUV">Philippines — Nueva Vizcaya</option>
                                    <option value="PH:MDC">Philippines — Occidental Mindoro</option>
                                    <option value="PH:MDR">Philippines — Oriental Mindoro</option>
                                    <option value="PH:PLW">Philippines — Palawan</option>
                                    <option value="PH:PAM">Philippines — Pampanga</option>
                                    <option value="PH:PAN">Philippines — Pangasinan</option>
                                    <option value="PH:QUE">Philippines — Quezon</option>
                                    <option value="PH:QUI">Philippines — Quirino</option>
                                    <option value="PH:RIZ">Philippines — Rizal</option>
                                    <option value="PH:ROM">Philippines — Romblon</option>
                                    <option value="PH:WSA">Philippines — Samar</option>
                                    <option value="PH:SAR">Philippines — Sarangani</option>
                                    <option value="PH:SIQ">Philippines — Siquijor</option>
                                    <option value="PH:SOR">Philippines — Sorsogon</option>
                                    <option value="PH:SCO">Philippines — South Cotabato</option>
                                    <option value="PH:SLE">Philippines — Southern Leyte</option>
                                    <option value="PH:SUK">Philippines — Sultan Kudarat</option>
                                    <option value="PH:SLU">Philippines — Sulu</option>
                                    <option value="PH:SUN">Philippines — Surigao del Norte</option>
                                    <option value="PH:SUR">Philippines — Surigao del Sur</option>
                                    <option value="PH:TAR">Philippines — Tarlac</option>
                                    <option value="PH:TAW">Philippines — Tawi-Tawi</option>
                                    <option value="PH:ZMB">Philippines — Zambales</option>
                                    <option value="PH:ZAN">Philippines — Zamboanga del Norte</option>
                                    <option value="PH:ZAS">Philippines — Zamboanga del Sur</option>
                                    <option value="PH:ZSI">Philippines — Zamboanga Sibugay</option>
                                    <option value="PH:00">Philippines — Metro Manila</option>

                                    <option value="PN">Pitcairn</option>
                                    <option value="PL">Poland</option>
                                    <option value="PT">Portugal</option>
                                    <option value="QA">Qatar</option>
                                    <option value="IE">Republic of Ireland</option>
                                    <option value="RE">Reunion</option>
                                    <option value="RO">Romania</option>
                                    <option value="RU">Russia</option>
                                    <option value="RW">Rwanda</option>
                                    <option value="ST">São Tomé and Príncipe</option>
                                    <option value="BL">Saint Barthélemy</option>
                                    <option value="SH">Saint Helena</option>
                                    <option value="KN">Saint Kitts and Nevis</option>
                                    <option value="LC">Saint Lucia</option>
                                    <option value="SX">Saint Martin (Dutch part)</option>
                                    <option value="MF">Saint Martin (French part)</option>
                                    <option value="PM">Saint Pierre and Miquelon</option>
                                    <option value="VC">Saint Vincent and the Grenadines</option>
                                    <option value="SM">San Marino</option>
                                    <option value="SA">Saudi Arabia</option>
                                    <option value="SN">Senegal</option>
                                    <option value="RS">Serbia</option>
                                    <option value="SC">Seychelles</option>
                                    <option value="SL">Sierra Leone</option>
                                    <option value="SG">Singapore</option>
                                    <option value="SK">Slovakia</option>
                                    <option value="SI">Slovenia</option>
                                    <option value="SB">Solomon Islands</option>
                                    <option value="SO">Somalia</option>

                                    <option value="ZA:EC">South Africa — Eastern Cape</option>
                                    <option value="ZA:FS">South Africa — Free State</option>
                                    <option value="ZA:GP">South Africa — Gauteng</option>
                                    <option value="ZA:KZN">South Africa — KwaZulu-Natal</option>
                                    <option value="ZA:LP">South Africa — Limpopo</option>
                                    <option value="ZA:MP">South Africa — Mpumalanga</option>
                                    <option value="ZA:NC">South Africa — Northern Cape</option>
                                    <option value="ZA:NW">South Africa — North West</option>
                                    <option value="ZA:WC">South Africa — Western Cape</option>

                                    <option value="GS">South Georgia/Sandwich Islands</option>
                                    <option value="KR">South Korea</option>
                                    <option value="SS">South Sudan</option>

                                    <option value="ES:C">Spain — A Coruña</option>
                                    <option value="ES:VI">Spain — Araba/Álava</option>
                                    <option value="ES:AB">Spain — Albacete</option>
                                    <option value="ES:A">Spain — Alicante</option>
                                    <option value="ES:AL">Spain — Almería</option>
                                    <option value="ES:O">Spain — Asturias</option>
                                    <option value="ES:AV">Spain — Ávila</option>
                                    <option value="ES:BA">Spain — Badajoz</option>
                                    <option value="ES:PM">Spain — Baleares</option>
                                    <option value="ES:B">Spain — Barcelona</option>
                                    <option value="ES:BU">Spain — Burgos</option>
                                    <option value="ES:CC">Spain — Cáceres</option>
                                    <option value="ES:CA">Spain — Cádiz</option>
                                    <option value="ES:S">Spain — Cantabria</option>
                                    <option value="ES:CS">Spain — Castellón</option>
                                    <option value="ES:CE">Spain — Ceuta</option>
                                    <option value="ES:CR">Spain — Ciudad Real</option>
                                    <option value="ES:CO">Spain — Córdoba</option>
                                    <option value="ES:CU">Spain — Cuenca</option>
                                    <option value="ES:GI">Spain — Girona</option>
                                    <option value="ES:GR">Spain — Granada</option>
                                    <option value="ES:GU">Spain — Guadalajara</option>
                                    <option value="ES:SS">Spain — Gipuzkoa</option>
                                    <option value="ES:H">Spain — Huelva</option>
                                    <option value="ES:HU">Spain — Huesca</option>
                                    <option value="ES:J">Spain — Jaén</option>
                                    <option value="ES:LO">Spain — La Rioja</option>
                                    <option value="ES:GC">Spain — Las Palmas</option>
                                    <option value="ES:LE">Spain — León</option>
                                    <option value="ES:L">Spain — Lleida</option>
                                    <option value="ES:LU">Spain — Lugo</option>
                                    <option value="ES:M">Spain — Madrid</option>
                                    <option value="ES:MA">Spain — Málaga</option>
                                    <option value="ES:ML">Spain — Melilla</option>
                                    <option value="ES:MU">Spain — Murcia</option>
                                    <option value="ES:NA">Spain — Navarra</option>
                                    <option value="ES:OR">Spain — Ourense</option>
                                    <option value="ES:P">Spain — Palencia</option>
                                    <option value="ES:PO">Spain — Pontevedra</option>
                                    <option value="ES:SA">Spain — Salamanca</option>
                                    <option value="ES:TF">Spain — Santa Cruz de Tenerife</option>
                                    <option value="ES:SG">Spain — Segovia</option>
                                    <option value="ES:SE">Spain — Sevilla</option>
                                    <option value="ES:SO">Spain — Soria</option>
                                    <option value="ES:T">Spain — Tarragona</option>
                                    <option value="ES:TE">Spain — Teruel</option>
                                    <option value="ES:TO">Spain — Toledo</option>
                                    <option value="ES:V">Spain — Valencia</option>
                                    <option value="ES:VA">Spain — Valladolid</option>
                                    <option value="ES:BI">Spain — Bizkaia</option>
                                    <option value="ES:ZA">Spain — Zamora</option>
                                    <option value="ES:Z">Spain — Zaragoza</option>

                                    <option value="LK">Sri Lanka</option>
                                    <option value="SD">Sudan</option>
                                    <option value="SR">Suriname</option>
                                    <option value="SJ">Svalbard and Jan Mayen</option>
                                    <option value="SZ">Swaziland</option>
                                    <option value="SE">Sweden</option>
                                    <option value="CH">Switzerland</option>
                                    <option value="SY">Syria</option>
                                    <option value="TW">Taiwan</option>
                                    <option value="TJ">Tajikistan</option>
                                    <option value="TZ">Tanzania</option>

                                    <option value="TH:TH-37">Thailand — Amnat Charoen (อำนาจเจริญ)</option>
                                    <option value="TH:TH-15">Thailand — Ang Thong (อ่างทอง)</option>
                                    <option value="TH:TH-14">Thailand — Ayutthaya (พระนครศรีอยุธยา)</option>
                                    <option value="TH:TH-10">Thailand — Bangkok (กรุงเทพมหานคร)</option>
                                    <option value="TH:TH-38">Thailand — Bueng Kan (บึงกาฬ)</option>
                                    <option value="TH:TH-31">Thailand — Buri Ram (บุรีรัมย์)</option>
                                    <option value="TH:TH-24">Thailand — Chachoengsao (ฉะเชิงเทรา)</option>
                                    <option value="TH:TH-18">Thailand — Chai Nat (ชัยนาท)</option>
                                    <option value="TH:TH-36">Thailand — Chaiyaphum (ชัยภูมิ)</option>
                                    <option value="TH:TH-22">Thailand — Chanthaburi (จันทบุรี)</option>
                                    <option value="TH:TH-50">Thailand — Chiang Mai (เชียงใหม่)</option>
                                    <option value="TH:TH-57">Thailand — Chiang Rai (เชียงราย)</option>
                                    <option value="TH:TH-20">Thailand — Chonburi (ชลบุรี)</option>
                                    <option value="TH:TH-86">Thailand — Chumphon (ชุมพร)</option>
                                    <option value="TH:TH-46">Thailand — Kalasin (กาฬสินธุ์)</option>
                                    <option value="TH:TH-62">Thailand — Kamphaeng Phet (กำแพงเพชร)</option>
                                    <option value="TH:TH-71">Thailand — Kanchanaburi (กาญจนบุรี)</option>
                                    <option value="TH:TH-40">Thailand — Khon Kaen (ขอนแก่น)</option>
                                    <option value="TH:TH-81">Thailand — Krabi (กระบี่)</option>
                                    <option value="TH:TH-52">Thailand — Lampang (ลำปาง)</option>
                                    <option value="TH:TH-51">Thailand — Lamphun (ลำพูน)</option>
                                    <option value="TH:TH-42">Thailand — Loei (เลย)</option>
                                    <option value="TH:TH-16">Thailand — Lopburi (ลพบุรี)</option>
                                    <option value="TH:TH-58">Thailand — Mae Hong Son (แม่ฮ่องสอน)</option>
                                    <option value="TH:TH-44">Thailand — Maha Sarakham (มหาสารคาม)</option>
                                    <option value="TH:TH-49">Thailand — Mukdahan (มุกดาหาร)</option>
                                    <option value="TH:TH-26">Thailand — Nakhon Nayok (นครนายก)</option>
                                    <option value="TH:TH-73">Thailand — Nakhon Pathom (นครปฐม)</option>
                                    <option value="TH:TH-48">Thailand — Nakhon Phanom (นครพนม)</option>
                                    <option value="TH:TH-30">Thailand — Nakhon Ratchasima (นครราชสีมา)</option>
                                    <option value="TH:TH-60">Thailand — Nakhon Sawan (นครสวรรค์)</option>
                                    <option value="TH:TH-80">Thailand — Nakhon Si Thammarat (นครศรีธรรมราช)</option>
                                    <option value="TH:TH-55">Thailand — Nan (น่าน)</option>
                                    <option value="TH:TH-96">Thailand — Narathiwat (นราธิวาส)</option>
                                    <option value="TH:TH-39">Thailand — Nong Bua Lam Phu (หนองบัวลำภู)</option>
                                    <option value="TH:TH-43">Thailand — Nong Khai (หนองคาย)</option>
                                    <option value="TH:TH-12">Thailand — Nonthaburi (นนทบุรี)</option>
                                    <option value="TH:TH-13">Thailand — Pathum Thani (ปทุมธานี)</option>
                                    <option value="TH:TH-94">Thailand — Pattani (ปัตตานี)</option>
                                    <option value="TH:TH-82">Thailand — Phang Nga (พังงา)</option>
                                    <option value="TH:TH-93">Thailand — Phatthalung (พัทลุง)</option>
                                    <option value="TH:TH-56">Thailand — Phayao (พะเยา)</option>
                                    <option value="TH:TH-67">Thailand — Phetchabun (เพชรบูรณ์)</option>
                                    <option value="TH:TH-76">Thailand — Phetchaburi (เพชรบุรี)</option>
                                    <option value="TH:TH-66">Thailand — Phichit (พิจิตร)</option>
                                    <option value="TH:TH-65">Thailand — Phitsanulok (พิษณุโลก)</option>
                                    <option value="TH:TH-54">Thailand — Phrae (แพร่)</option>
                                    <option value="TH:TH-83">Thailand — Phuket (ภูเก็ต)</option>
                                    <option value="TH:TH-25">Thailand — Prachin Buri (ปราจีนบุรี)</option>
                                    <option value="TH:TH-77">Thailand — Prachuap Khiri Khan (ประจวบคีรีขันธ์)</option>
                                    <option value="TH:TH-85">Thailand — Ranong (ระนอง)</option>
                                    <option value="TH:TH-70">Thailand — Ratchaburi (ราชบุรี)</option>
                                    <option value="TH:TH-21">Thailand — Rayong (ระยอง)</option>
                                    <option value="TH:TH-45">Thailand — Roi Et (ร้อยเอ็ด)</option>
                                    <option value="TH:TH-27">Thailand — Sa Kaeo (สระแก้ว)</option>
                                    <option value="TH:TH-47">Thailand — Sakon Nakhon (สกลนคร)</option>
                                    <option value="TH:TH-11">Thailand — Samut Prakan (สมุทรปราการ)</option>
                                    <option value="TH:TH-74">Thailand — Samut Sakhon (สมุทรสาคร)</option>
                                    <option value="TH:TH-75">Thailand — Samut Songkhram (สมุทรสงคราม)</option>
                                    <option value="TH:TH-19">Thailand — Saraburi (สระบุรี)</option>
                                    <option value="TH:TH-91">Thailand — Satun (สตูล)</option>
                                    <option value="TH:TH-17">Thailand — Sing Buri (สิงห์บุรี)</option>
                                    <option value="TH:TH-33">Thailand — Sisaket (ศรีสะเกษ)</option>
                                    <option value="TH:TH-90">Thailand — Songkhla (สงขลา)</option>
                                    <option value="TH:TH-64">Thailand — Sukhothai (สุโขทัย)</option>
                                    <option value="TH:TH-72">Thailand — Suphan Buri (สุพรรณบุรี)</option>
                                    <option value="TH:TH-84">Thailand — Surat Thani (สุราษฎร์ธานี)</option>
                                    <option value="TH:TH-32">Thailand — Surin (สุรินทร์)</option>
                                    <option value="TH:TH-63">Thailand — Tak (ตาก)</option>
                                    <option value="TH:TH-92">Thailand — Trang (ตรัง)</option>
                                    <option value="TH:TH-23">Thailand — Trat (ตราด)</option>
                                    <option value="TH:TH-34">Thailand — Ubon Ratchathani (อุบลราชธานี)</option>
                                    <option value="TH:TH-41">Thailand — Udon Thani (อุดรธานี)</option>
                                    <option value="TH:TH-61">Thailand — Uthai Thani (อุทัยธานี)</option>
                                    <option value="TH:TH-53">Thailand — Uttaradit (อุตรดิตถ์)</option>
                                    <option value="TH:TH-95">Thailand — Yala (ยะลา)</option>
                                    <option value="TH:TH-35">Thailand — Yasothon (ยโสธร)</option>

                                    <option value="TL">Timor-Leste</option>
                                    <option value="TG">Togo</option>
                                    <option value="TK">Tokelau</option>
                                    <option value="TO">Tonga</option>
                                    <option value="TT">Trinidad and Tobago</option>
                                    <option value="TN">Tunisia</option>

                                    <option value="TR:TR01">Turkey — Adana</option>
                                    <option value="TR:TR02">Turkey — Adıyaman</option>
                                    <option value="TR:TR03">Turkey — Afyon</option>
                                    <option value="TR:TR04">Turkey — Ağrı</option>
                                    <option value="TR:TR05">Turkey — Amasya</option>
                                    <option value="TR:TR06">Turkey — Ankara</option>
                                    <option value="TR:TR07">Turkey — Antalya</option>
                                    <option value="TR:TR08">Turkey — Artvin</option>
                                    <option value="TR:TR09">Turkey — Aydın</option>
                                    <option value="TR:TR10">Turkey — Balıkesir</option>
                                    <option value="TR:TR11">Turkey — Bilecik</option>
                                    <option value="TR:TR12">Turkey — Bingöl</option>
                                    <option value="TR:TR13">Turkey — Bitlis</option>
                                    <option value="TR:TR14">Turkey — Bolu</option>
                                    <option value="TR:TR15">Turkey — Burdur</option>
                                    <option value="TR:TR16">Turkey — Bursa</option>
                                    <option value="TR:TR17">Turkey — Çanakkale</option>
                                    <option value="TR:TR18">Turkey — Çankırı</option>
                                    <option value="TR:TR19">Turkey — Çorum</option>
                                    <option value="TR:TR20">Turkey — Denizli</option>
                                    <option value="TR:TR21">Turkey — Diyarbakır</option>
                                    <option value="TR:TR22">Turkey — Edirne</option>
                                    <option value="TR:TR23">Turkey — Elazığ</option>
                                    <option value="TR:TR24">Turkey — Erzincan</option>
                                    <option value="TR:TR25">Turkey — Erzurum</option>
                                    <option value="TR:TR26">Turkey — Eskişehir</option>
                                    <option value="TR:TR27">Turkey — Gaziantep</option>
                                    <option value="TR:TR28">Turkey — Giresun</option>
                                    <option value="TR:TR29">Turkey — Gümüşhane</option>
                                    <option value="TR:TR30">Turkey — Hakkari</option>
                                    <option value="TR:TR31">Turkey — Hatay</option>
                                    <option value="TR:TR32">Turkey — Isparta</option>
                                    <option value="TR:TR33">Turkey — İçel</option>
                                    <option value="TR:TR34">Turkey — İstanbul</option>
                                    <option value="TR:TR35">Turkey — İzmir</option>
                                    <option value="TR:TR36">Turkey — Kars</option>
                                    <option value="TR:TR37">Turkey — Kastamonu</option>
                                    <option value="TR:TR38">Turkey — Kayseri</option>
                                    <option value="TR:TR39">Turkey — Kırklareli</option>
                                    <option value="TR:TR40">Turkey — Kırşehir</option>
                                    <option value="TR:TR41">Turkey — Kocaeli</option>
                                    <option value="TR:TR42">Turkey — Konya</option>
                                    <option value="TR:TR43">Turkey — Kütahya</option>
                                    <option value="TR:TR44">Turkey — Malatya</option>
                                    <option value="TR:TR45">Turkey — Manisa</option>
                                    <option value="TR:TR46">Turkey — Kahramanmaraş</option>
                                    <option value="TR:TR47">Turkey — Mardin</option>
                                    <option value="TR:TR48">Turkey — Muğla</option>
                                    <option value="TR:TR49">Turkey — Muş</option>
                                    <option value="TR:TR50">Turkey — Nevşehir</option>
                                    <option value="TR:TR51">Turkey — Niğde</option>
                                    <option value="TR:TR52">Turkey — Ordu</option>
                                    <option value="TR:TR53">Turkey — Rize</option>
                                    <option value="TR:TR54">Turkey — Sakarya</option>
                                    <option value="TR:TR55">Turkey — Samsun</option>
                                    <option value="TR:TR56">Turkey — Siirt</option>
                                    <option value="TR:TR57">Turkey — Sinop</option>
                                    <option value="TR:TR58">Turkey — Sivas</option>
                                    <option value="TR:TR59">Turkey — Tekirdağ</option>
                                    <option value="TR:TR60">Turkey — Tokat</option>
                                    <option value="TR:TR61">Turkey — Trabzon</option>
                                    <option value="TR:TR62">Turkey — Tunceli</option>
                                    <option value="TR:TR63">Turkey — Şanlıurfa</option>
                                    <option value="TR:TR64">Turkey — Uşak</option>
                                    <option value="TR:TR65">Turkey — Van</option>
                                    <option value="TR:TR66">Turkey — Yozgat</option>
                                    <option value="TR:TR67">Turkey — Zonguldak</option>
                                    <option value="TR:TR68">Turkey — Aksaray</option>
                                    <option value="TR:TR69">Turkey — Bayburt</option>
                                    <option value="TR:TR70">Turkey — Karaman</option>
                                    <option value="TR:TR71">Turkey — Kırıkkale</option>
                                    <option value="TR:TR72">Turkey — Batman</option>
                                    <option value="TR:TR73">Turkey — Şırnak</option>
                                    <option value="TR:TR74">Turkey — Bartın</option>
                                    <option value="TR:TR75">Turkey — Ardahan</option>
                                    <option value="TR:TR76">Turkey — Iğdır</option>
                                    <option value="TR:TR77">Turkey — Yalova</option>
                                    <option value="TR:TR78">Turkey — Karabük</option>
                                    <option value="TR:TR79">Turkey — Kilis</option>
                                    <option value="TR:TR80">Turkey — Osmaniye</option>
                                    <option value="TR:TR81">Turkey — Düzce</option>

                                    <option value="TM">Turkmenistan</option>
                                    <option value="TC">Turks and Caicos Islands</option>
                                    <option value="TV">Tuvalu</option>
                                    <option value="UG">Uganda</option>
                                    <option value="UA">Ukraine</option>
                                    <option value="AE">United Arab Emirates</option>
                                    <option value="GB">United Kingdom (UK)</option>

                                    <option value="US:AL">United States (US) — Alabama</option>
                                    <option value="US:AK">United States (US) — Alaska</option>
                                    <option value="US:AZ">United States (US) — Arizona</option>
                                    <option value="US:AR">United States (US) — Arkansas</option>
                                    <option value="US:CA">United States (US) — California</option>
                                    <option value="US:CO">United States (US) — Colorado</option>
                                    <option value="US:CT">United States (US) — Connecticut</option>
                                    <option value="US:DE">United States (US) — Delaware</option>
                                    <option value="US:DC">United States (US) — District Of Columbia</option>
                                    <option value="US:FL">United States (US) — Florida</option>
                                    <option value="US:GA">United States (US) — Georgia</option>
                                    <option value="US:HI">United States (US) — Hawaii</option>
                                    <option value="US:ID">United States (US) — Idaho</option>
                                    <option value="US:IL">United States (US) — Illinois</option>
                                    <option value="US:IN">United States (US) — Indiana</option>
                                    <option value="US:IA">United States (US) — Iowa</option>
                                    <option value="US:KS">United States (US) — Kansas</option>
                                    <option value="US:KY">United States (US) — Kentucky</option>
                                    <option value="US:LA">United States (US) — Louisiana</option>
                                    <option value="US:ME">United States (US) — Maine</option>
                                    <option value="US:MD">United States (US) — Maryland</option>
                                    <option value="US:MA">United States (US) — Massachusetts</option>
                                    <option value="US:MI">United States (US) — Michigan</option>
                                    <option value="US:MN">United States (US) — Minnesota</option>
                                    <option value="US:MS">United States (US) — Mississippi</option>
                                    <option value="US:MO">United States (US) — Missouri</option>
                                    <option value="US:MT">United States (US) — Montana</option>
                                    <option value="US:NE">United States (US) — Nebraska</option>
                                    <option value="US:NV">United States (US) — Nevada</option>
                                    <option value="US:NH">United States (US) — New Hampshire</option>
                                    <option value="US:NJ">United States (US) — New Jersey</option>
                                    <option value="US:NM">United States (US) — New Mexico</option>
                                    <option value="US:NY">United States (US) — New York</option>
                                    <option value="US:NC">United States (US) — North Carolina</option>
                                    <option value="US:ND">United States (US) — North Dakota</option>
                                    <option value="US:OH">United States (US) — Ohio</option>
                                    <option value="US:OK">United States (US) — Oklahoma</option>
                                    <option value="US:OR">United States (US) — Oregon</option>
                                    <option value="US:PA">United States (US) — Pennsylvania</option>
                                    <option value="US:RI">United States (US) — Rhode Island</option>
                                    <option value="US:SC">United States (US) — South Carolina</option>
                                    <option value="US:SD">United States (US) — South Dakota</option>
                                    <option value="US:TN">United States (US) — Tennessee</option>
                                    <option value="US:TX">United States (US) — Texas</option>
                                    <option value="US:UT">United States (US) — Utah</option>
                                    <option value="US:VT">United States (US) — Vermont</option>
                                    <option value="US:VA">United States (US) — Virginia</option>
                                    <option value="US:WA">United States (US) — Washington</option>
                                    <option value="US:WV">United States (US) — West Virginia</option>
                                    <option value="US:WI">United States (US) — Wisconsin</option>
                                    <option value="US:WY">United States (US) — Wyoming</option>
                                    <option value="US:AA">United States (US) — Armed Forces (AA)</option>
                                    <option value="US:AE">United States (US) — Armed Forces (AE)</option>
                                    <option value="US:AP">United States (US) — Armed Forces (AP)</option>
                                    <option value="US:AS">United States (US) — American Samoa</option>
                                    <option value="US:GU">United States (US) — Guam</option>
                                    <option value="US:MP">United States (US) — Northern Mariana Islands</option>
                                    <option value="US:PR">United States (US) — Puerto Rico</option>
                                    <option value="US:UM">United States (US) — US Minor Outlying Islands</option>
                                    <option value="US:VI">United States (US) — US Virgin Islands</option>

                                    <option value="UY">Uruguay</option>
                                    <option value="UZ">Uzbekistan</option>
                                    <option value="VU">Vanuatu</option>
                                    <option value="VA">Vatican</option>
                                    <option value="VE">Venezuela</option>
                                    <option value="VN">Vietnam</option>
                                    <option value="WF">Wallis and Futuna</option>
                                    <option value="EH">Western Sahara</option>
                                    <option value="WS">Western Samoa</option>
                                    <option value="YE">Yemen</option>
                                    <option value="ZM">Zambia</option>
                                    <option value="ZW">Zimbabwe</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="currency_code">Which currency will your store use?</label>
                        </th>
                        <td>
                            <div style="width:100%;" id="s2id_currency_code" class="select2-container wc-enhanced-select enhanced">
                                
                                <label for="s2id_autogen2" class="select2-offscreen">Which currency will your store use?</label>
                                <input id="s2id_autogen2" aria-labelledby="select2-chosen-2" class="select2-focusser select2-offscreen" aria-haspopup="true" role="button" type="text">
                                <div class="select2-drop select2-display-none select2-with-searchbox">
                                    <div class="select2-search">
                                        <label for="s2id_autogen2_search" class="select2-offscreen">Which currency will your store use?</label>
                                        <input placeholder="" id="s2id_autogen2_search" aria-owns="select2-results-2" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" type="text">
                                    </div>
                                    <ul id="select2-results-2" class="select2-results" role="listbox"></ul>
                                </div>
                            </div>
                            <select>
                                <option selected="selected" value="">Choose a currency…</option>
                                <option value="AED">United Arab Emirates Dirham (د.إ)</option>
                                <option value="ARS">Argentine Peso ($)</option>
                                <option value="AUD">Australian Dollars ($)</option>
                                <option value="BDT">Bangladeshi Taka (৳&nbsp;)</option>
                                <option value="BRL">Brazilian Real (R$)</option>
                                <option value="BGN">Bulgarian Lev (лв.)</option>
                                <option value="CAD">Canadian Dollars ($)</option>
                                <option value="CLP">Chilean Peso ($)</option>
                                <option value="CNY">Chinese Yuan (¥)</option>
                                <option value="COP">Colombian Peso ($)</option>
                                <option value="CZK">Czech Koruna (Kč)</option>
                                <option value="DKK">Danish Krone (DKK)</option>
                                <option value="DOP">Dominican Peso (RD$)</option>
                                <option value="EUR">Euros (€)</option>
                                <option value="HKD">Hong Kong Dollar ($)</option>
                                <option value="HRK">Croatia kuna (Kn)</option>
                                <option value="HUF">Hungarian Forint (Ft)</option>
                                <option value="ISK">Icelandic krona (Kr.)</option>
                                <option value="IDR">Indonesia Rupiah (Rp)</option>
                                <option value="INR">Indian Rupee (Rs.)</option>
                                <option value="NPR">Nepali Rupee (Rs.)</option>
                                <option value="ILS">Israeli Shekel (₪)</option>
                                <option value="JPY">Japanese Yen (¥)</option>
                                <option value="KIP">Lao Kip (₭)</option>
                                <option value="KRW">South Korean Won (₩)</option>
                                <option value="MYR">Malaysian Ringgits (RM)</option>
                                <option value="MXN">Mexican Peso ($)</option>
                                <option value="NGN">Nigerian Naira (₦)</option>
                                <option value="NOK">Norwegian Krone (kr)</option>
                                <option value="NZD">New Zealand Dollar ($)</option>
                                <option value="PYG">Paraguayan Guaraní (₲)</option>
                                <option value="PHP">Philippine Pesos (₱)</option>
                                <option value="PLN">Polish Zloty (zł)</option>
                                <option value="GBP" checked="checked">Pounds Sterling (£)</option>
                                <option value="RON">Romanian Leu (lei)</option>
                                <option value="RUB">Russian Ruble (руб.)</option>
                                <option value="SGD">Singapore Dollar ($)</option>
                                <option value="ZAR">South African rand (R)</option>
                                <option value="SEK">Swedish Krona (kr)</option>
                                <option value="CHF">Swiss Franc (CHF)</option>
                                <option value="TWD">Taiwan New Dollars (NT$)</option>
                                <option value="THB">Thai Baht (฿)</option>
                                <option value="TRY">Turkish Lira (₺)</option>
                                <option value="UAH">Ukrainian Hryvnia (₴)</option>
                                <option value="USD">US Dollars ($)</option>
                                <option value="VND">Vietnamese Dong (₫)</option>
                                <option value="EGP">Egyptian Pound (EGP)</option>
                            </select>
                            <span class="description">If your currency is not listed you can <a href="http://docs.woothemes.com/document/add-a-custom-currency-symbol/" target="_blank">add it later</a>.</span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="currency_pos">Currency Position</label>
                        </th>
                        <td>
                            <div id="s2id_currency_pos" class="select2-container wc-enhanced-select enhanced">
                             
                               
                                <label for="s2id_autogen3" class="select2-offscreen">Currency Position</label>
                                <input id="s2id_autogen3" aria-labelledby="select2-chosen-3" class="select2-focusser select2-offscreen" aria-haspopup="true" role="button" type="text">
                                <div class="select2-drop select2-display-none select2-with-searchbox">
                                    <div class="select2-search">
                                        <label for="s2id_autogen3_search" class="select2-offscreen">Currency Position</label>
                                        <input placeholder="" id="s2id_autogen3_search" aria-owns="select2-results-3" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" type="text">
                                    </div>
                                    <ul id="select2-results-3" class="select2-results" role="listbox"></ul>
                                </div>
                            </div>
                            <select>
                                <option value="left" selected="selected">Left</option>
                                <option value="right">Right</option>
                                <option value="left_space">Left with space</option>
                                <option value="right_space">Right with space</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="thousand_sep">Thousand Separator</label>
                        </th>
                        <td>
                            <input id="thousand_sep" name="thousand_sep" size="2" value="," type="text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="decimal_sep">Decimal Separator</label>
                        </th>
                        <td>
                            <input id="decimal_sep" name="decimal_sep" size="2" value="." type="text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="weight_unit">Which unit should be used for product weights?</label>
                        </th>
                        <td>
                            <div id="s2id_weight_unit" class="select2-container wc-enhanced-select enhanced">
                                
                                <label for="s2id_autogen4" class="select2-offscreen">Which unit should be used for product weights?</label>
                                <input id="s2id_autogen4" aria-labelledby="select2-chosen-4" class="select2-focusser select2-offscreen" aria-haspopup="true" role="button" type="text">
                                <div class="select2-drop select2-display-none select2-with-searchbox">
                                    <div class="select2-search">
                                        <label for="s2id_autogen4_search" class="select2-offscreen">Which unit should be used for product weights?</label>
                                        <input placeholder="" id="s2id_autogen4_search" aria-owns="select2-results-4" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" type="text">
                                    </div>
                                    <ul id="select2-results-4" class="select2-results" role="listbox"></ul>
                                </div>
                            </div>
                            <select >
                                <option value="kg" selected="selected">kg</option>
                                <option value="g">g</option>
                                <option value="lbs">lbs</option>
                                <option value="oz">oz</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="dimension_unit">Which unit should be used for product dimensions?</label>
                        </th>
                        <td>
                            <div id="s2id_dimension_unit" class="select2-container wc-enhanced-select enhanced">
                               
                               
                                <label for="s2id_autogen5" class="select2-offscreen">Which unit should be used for product dimensions?</label>
                                <input id="s2id_autogen5" aria-labelledby="select2-chosen-5" class="select2-focusser select2-offscreen" aria-haspopup="true" role="button" type="text">
                                <div class="select2-drop select2-display-none select2-with-searchbox">
                                    <div class="select2-search">
                                        <label for="s2id_autogen5_search" class="select2-offscreen">Which unit should be used for product dimensions?</label>
                                        <input placeholder="" id="s2id_autogen5_search" aria-owns="select2-results-5" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="select2-input" role="combobox" aria-expanded="true" aria-autocomplete="list" type="text">
                                    </div>
                                    <ul id="select2-results-5" class="select2-results" role="listbox"></ul>
                                </div>
                            </div>
                            <select >
                                <option value="m">m</option>
                                <option value="cm" selected="selected">cm</option>
                                <option value="mm">mm</option>
                                <option value="in">in</option>
                                <option value="yd">yd</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p>Once created, these pages can be managed from your admin dashboard on the <a href="http://jamboreebliss.com/wp/wp-admin/edit.php?post_type=page" target="_blank">Pages screen</a>. You can control which pages are shown on your website via <a href="http://jamboreebliss.com/wp/wp-admin/nav-menus.php" target="_blank">Appearance &gt; Menus</a>.</p>

            <p class="wc-setup-actions step">
                <a href="step3.html" class="button-primary button button-large button-next">Continue</a>
                <a href="#" class="button button-large button-next">Skip this step</a>
            </p>
        </form>
    </div>

    <span class="select2-hidden-accessible" aria-live="polite" role="status"></span>
</body>

</html>