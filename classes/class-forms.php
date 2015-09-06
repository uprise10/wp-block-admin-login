<?php

class WP_Block_Admin_Login_Forms {

	protected $text_domain;

	function __construct() {
		$this->text_domain = WP_Block_Admin_Login_Core::instance()->text_domain;
	}

	/**
	 * @param        $value
	 * @param        $name
	 * @param array  $args
	 *
	 * @return string
	 */
	static function text( $name, $value = '', $args = array() ) {
		$args = wp_parse_args( (array) $args, array(
			'id'   => '',
			'type' => 'text',
			'placeholder' => ''
		) );

		return '<input type="' . $args['type'] . '" name="' . $name . '" id="' . $args['id'] . '" value="' . esc_attr( $value ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" class="regular-text" />';
	}

	/**
	 * @param       $value
	 * @param       $name
	 * @param array $args
	 *
	 * @return string
	 */
	static function textarea( $name, $value = '', $args = array() ) {
		$args = wp_parse_args( (array) $args, array(
			'id'    => '',
			'class' => 'regular-text',
			'rte'   => false,
			'cols'  => 40,
			'rows'  => 5
		) );

		$output = '';
		if ( true == $args['rte'] ) {
			$output .= '<div id="poststuff" class="teeny">';
			wp_editor( $value, $args['id'], array(
				'name'          => $name,
				'wpautop'       => true,
				'media_buttons' => false,
				'textarea_rows' => 10,
				'quicktags'     => true
			) );
			$output .= '</div>';
		} else {
			$output .= '<textarea name="' . $name . '" id="' . $args['id'] . '" cols="' . $args['cols'] . '" rows="' . $args['rows'] . '" class="' . $args['class'] . '">' . esc_attr( $value ) . '</textarea>';
		}

		return $output;
	}

	/**
	 * @param        $name
	 * @param string $value
	 * @param array  $args
	 *
	 * @return string
	 */
	static function checkbox( $name, $value = 'on', $args = array() ) {
		$args = wp_parse_args( (array) $args, array(
			'id'    => '',
			'value' => 'on'
		) );

		return '<input type="checkbox" name="' . $name . '" id="' . $args['id'] . '" value="' . esc_attr( $args['value'] ) . '" ' . checked( $args['value'], $value, false ) . ' class="checkbox">';
	}

	/**
	 * @param       $name
	 * @param null  $value
	 * @param array $args
	 *
	 * @return string
	 */
	static function upload( $name, $value = null, $args = array() ) {
		$args = wp_parse_args( (array) $args, array(
			'id' => ''
		) );

		$output = '<input type="file" name="' . $name . '" id="' . $args['id'] . '">';

		if ( ! empty( $value ) ) {
			$output .= '<br><small>' . __( 'Current file', $this->text_domain ) . ': <a href="' . $value . '" target="_blank">' . $value . '</a></small>';
		}

		return $output;
	}

	/**
	 * @param       $name
	 * @param null  $value
	 * @param array $options
	 * @param array $args
	 *
	 * @return string
	 */
	static function radio( $name, $value = null, $options = array(), $args = array() ) {
		$args = wp_parse_args( (array) $args, array(
			'id'    => '',
			'class' => ''
		) );

		$output = '';

		if ( is_array( $options ) ) {
			foreach ( $options as $key => $label ) {
				$output .= '<span class="field-wrapper-radio"><label for="' . $args['id'] . '-' . $key . '"><input type="radio" value="' . esc_attr( $key ) . '" name="' . $name . '" id="' . $args['id'] . '-' . $key . '" class="' . $args['class'] . '" ' . checked( $key, $value, false ) . '> ' . $label . '</label></span><br>';
			}
		}

		return $output;
	}

	/**
	 * @param       $name
	 * @param null  $value
	 * @param array $options
	 * @param array $args
	 *
	 * @return string
	 */
	static function select( $name, $value = null, $options = array(), $args = array() ) {
		$args = wp_parse_args( (array) $args, array(
			'id'    => '',
			'class' => ''
		) );

		$output = '<select name="' . $name . '" id="' . $args['id'] . '" class="' . $args['class'] . '">';

		if ( is_array( $options ) ) {
			foreach ( $options as $key => $label ) {
				$output .= '<option value="' . $key . '"' . selected( $key, $value, false ) . '>' . $label . '</option>';
			}
		}
		$output .= '</select>';

		return $output;
	}

	/**
	 * @param       $name
	 * @param null  $value
	 * @param array $args
	 *
	 * @return string
	 */
	static function country( $name, $value = null, $args = array() ) {
		$args = wp_parse_args( (array) $args, array(
			'id'            => '',
			'class'         => '',
			'default_value' => ''
		) );

		if ( empty( $value ) && isset( $args['default_value'] ) ) {
			$value = $args['default_value'];
		}

		$countries = array(
			'NL' => 'Nederland',
			'BE' => 'Belgi&emul;',
			''   => '-----------',
			'AF' => 'Afghanistan',
			'AX' => '&Aring;land Eilanden',
			'AL' => 'Albani&euml;',
			'DZ' => 'Algerije',
			'VI' => 'Amerikaanse Maagdeneilanden',
			'AS' => 'Amerikaans Samoa',
			'AD' => 'Andorra',
			'AO' => 'Angola',
			'AI' => 'Anguilla',
			'AQ' => 'Antartica',
			'AG' => 'Antigua en Barbuda',
			'AR' => 'Argentini&euml;',
			'AM' => 'Armeni&euml;',
			'AW' => 'Aruba',
			'AU' => 'Australi&euml;',
			'AZ' => 'Azerbeidzjan',
			'BS' => 'Bahama’s',
			'BH' => 'Bahrein',
			'BD' => 'Bangladesh',
			'BB' => 'Barbados',
			'BY' => 'Belarus (Witrusland)',
			'BE' => 'Belgi&euml;',
			'BZ' => 'Belize',
			'BJ' => 'Benin',
			'BM' => 'Bermuda',
			'BT' => 'Bhutan',
			'MM' => 'Birma (Myanmar)',
			'BO' => 'Bolivia',
			'BQ' => 'Bonaire, St. Eustatius en Saba',
			'BA' => 'Bosni&euml;-Herzegowina',
			'BW' => 'Botswana',
			'BV' => 'Bouvet eiland',
			'BR' => 'Brazili&euml;',
			'IO' => 'Brits-Indische Oceaan',
			'VG' => 'Britse Maagdeneilanden',
			'BN' => 'Brunei Dar-es-Salaam',
			'BG' => 'Bulgarije',
			'BF' => 'Burkina Faso',
			'BI' => 'Burundi',
			'KH' => 'Cambodja',
			'CA' => 'Canada',
			'CF' => 'Centraal Afrikaanse Republiek',
			'CL' => 'Chili',
			'CN' => 'China',
			'CX' => 'Christmas eiland',
			'CC' => 'Cocos Eilanden',
			'CO' => 'Colombia',
			'KM' => 'Comoren',
			'CK' => 'Cook Eilanden',
			'CR' => 'Costa Rica',
			'CU' => 'Cuba',
			'CW' => 'Cura&ccedil;ao',
			'CY' => 'Cyprus',
			'DK' => 'Denemarken',
			'DJ' => 'Djibouti',
			'DM' => 'Dominika',
			'DO' => 'Dominikaanse Republiek',
			'DE' => 'Duitsland',
			'EC' => 'Ecuador',
			'EG' => 'Egypte',
			'IM' => 'Eiland Man',
			'SV' => 'El Salvador',
			'GQ' => 'Equatoriaal-Guinee',
			'ER' => 'Eritrea',
			'EE' => 'Estland',
			'ET' => 'Ethiopi&euml;',
			'FK' => 'Falkland Eilanden',
			'FO' => 'Far&ouml;er eilanden',
			'FJ' => 'Fiji',
			'PH' => 'Filippijnen',
			'FI' => 'Finland',
			'FR' => 'Frankrijk',
			'GF' => 'Frans Guyana',
			'PF' => 'Frans Polynesi&euml;',
			'TF' => 'Frans Zuidelijke Territoria',
			'GA' => 'Gabon',
			'GM' => 'Gambia',
			'GE' => 'Georgi&euml;',
			'GH' => 'Ghana',
			'GI' => 'Gibraltar',
			'GD' => 'Grenada',
			'GR' => 'Griekenland',
			'GL' => 'Groenland',
			'GB' => 'Groot Brittanni&euml;',
			'GP' => 'Guadeloupe',
			'GU' => 'Guam',
			'GT' => 'Guatemala',
			'GG' => 'Guernsey',
			'GN' => 'Guinee',
			'GW' => 'Guinee-Bissau',
			'GY' => 'Guyana',
			'HT' => 'Haïti',
			'HM' => 'Heard en McDonald eilanden',
			'HN' => 'Honduras',
			'HU' => 'Hongarije',
			'HK' => 'Hong Kong',
			'IE' => 'Ierland',
			'IS' => 'IJsland',
			'IN' => 'India',
			'ID' => 'Indonesi&euml;',
			'IQ' => 'Irak',
			'IR' => 'Iran',
			'IL' => 'Isra&euml;l',
			'IT' => 'Itali&euml;',
			'CI' => 'Ivoorkust',
			'JM' => 'Jamaica',
			'JP' => 'Japan',
			'YE' => 'Jemen',
			'JE' => 'Jersey',
			'JO' => 'Jordani&euml;',
			'KY' => 'Kaaimaneilanden',
			'CV' => 'Kaap Verdi&euml;',
			'CM' => 'Kameroen',
			'KZ' => 'Kazachstan',
			'KE' => 'Kenia',
			'KI' => 'Kiribati',
			'KG' => 'Kirgizi&euml;',
			'KW' => 'Koeweit',
			'CD' => 'Kongo (Dem. Rep.)',
			'CG' => 'Kongo (Volksrep.)',
			'KP' => 'Korea (Noord Korea)',
			'KR' => 'Korea (Zuid Korea)',
			'HR' => 'Kroati&euml;',
			'LA' => 'Laos',
			'LS' => 'Lesotho',
			'LV' => 'Letland',
			'LB' => 'Libanon',
			'LR' => 'Liberia',
			'LY' => 'Libi&euml;',
			'LI' => 'Liechtenstein',
			'LT' => 'Litouwen',
			'LU' => 'Luxemburg',
			'MO' => 'Macao',
			'MK' => 'Macedoni&euml;',
			'MG' => 'Madagaskar',
			'MW' => 'Malawi',
			'MY' => 'Maleisi&euml;',
			'MV' => 'Malediven',
			'ML' => 'Mali',
			'MT' => 'Malta',
			'MA' => 'Marokko',
			'MQ' => 'Martinique',
			'MH' => 'Marshall eilanden',
			'MR' => 'Mauretani&euml;',
			'MU' => 'Mauritius',
			'YT' => 'Mayotte',
			'MX' => 'Mexico',
			'FM' => 'Micronesi&euml;',
			'MD' => 'Moldavi&euml;',
			'MC' => 'Monaco',
			'MN' => 'Mongoli&euml;',
			'ME' => 'Montenegro',
			'MS' => 'Montserrat',
			'MZ' => 'Mozambique',
			'NA' => 'Namibi&euml;',
			'NR' => 'Nauru',
			'NL' => 'Nederland',
			'NP' => 'Nepal',
			'NI' => 'Nicaragua',
			'NC' => 'Nieuw Caledoni&euml;',
			'NZ' => 'Nieuw-Zeeland',
			'NE' => 'Niger',
			'NG' => 'Nigeria',
			'NU' => 'Niue',
			'MP' => 'Noordelijke Mariane eilanden',
			'NO' => 'Noorwegen',
			'NF' => 'Norfolk Eilanden',
			'UG' => 'Oeganda',
			'UA' => 'Oekraïne',
			'UZ' => 'Oezbekistan',
			'OM' => 'Oman',
			'AT' => 'Oostenrijk',
			'TL' => 'Oost Timor',
			'PK' => 'Pakistan',
			'PW' => 'Palau',
			'PS' => 'Palestijnse Gebieden',
			'PA' => 'Panama',
			'PG' => 'Papoea Nieuw-Guinea',
			'PY' => 'Paraguay',
			'PE' => 'Peru',
			'PN' => 'Pitcairn',
			'PL' => 'Polen',
			'PR' => 'Porto Rico',
			'PT' => 'Portugal',
			'QA' => 'Quatar',
			'RE' => 'R&eacute;union',
			'RO' => 'Roemeni&euml;',
			'RU' => 'Russische Federatie',
			'RW' => 'Rwanda',
			'WS' => 'Samoa',
			'SM' => 'San Marino',
			'SA' => 'Saoedi Arabi&euml;',
			'ST' => 'Sao Tome en Principe',
			'SN' => 'Senegal',
			'RS' => 'Servi&euml;',
			'SC' => 'Seychellen',
			'SL' => 'Sierra Leone',
			'SG' => 'Singapore',
			'SI' => 'Sloveni&euml;',
			'SK' => 'Slowakije',
			'SD' => 'Soedan',
			'SB' => 'Solomon Eilanden',
			'SO' => 'Somali&euml;',
			'ES' => 'Spanje',
			'SJ' => 'Spitsbergen en Jan Mayen eilanden',
			'LK' => 'Sri Lanka',
			'BL' => 'St. Bartl&eacute;my',
			'SH' => 'St. Helena',
			'KN' => 'St. Kitts en Nevis',
			'LC' => 'St. Lucia',
			'SX' => 'St. Maarten (NL)',
			'MF' => 'St. Martin (FR)',
			'PM' => 'St. Pierre en Miquelon',
			'VC' => 'St. Vincent en de Grenadinen',
			'SR' => 'Suriname',
			'SZ' => 'Swaziland',
			'SY' => 'Syri&euml;',
			'TJ' => 'Tadzjikistan',
			'TW' => 'Taiwan',
			'TZ' => 'Tanzania',
			'TH' => 'Thailand',
			'TG' => 'Togo',
			'TK' => 'Tokelau',
			'TO' => 'Tonga',
			'TT' => 'Trinidad en Tobago',
			'TD' => 'Tsjaad',
			'CZ' => 'Tsjechi&euml;',
			'TN' => 'Tunesi&euml;',
			'TR' => 'Turkije',
			'TM' => 'Turkmenistan',
			'TC' => 'Turks en Caicos eilanden',
			'TV' => 'Tuvalu',
			'UY' => 'Uruguay',
			'US' => 'USA',
			'UM' => 'USA - buitengebied kleine eilanden',
			'VU' => 'Vanuatu',
			'VA' => 'Vaticaanstad',
			'VE' => 'Venezuela',
			'UK' => 'Verenigd Koninkrijk',
			'AE' => 'Verenigde Arabische Emiraten',
			'VN' => 'Vietnam',
			'WF' => 'Wallis en Futuna',
			'EH' => 'Westelijke Sahara',
			'ZM' => 'Zambia',
			'ZW' => 'Zimbabwe',
			'ZA' => 'Zuid-Afrika',
			'GS' => 'Zuid-Georgia en zuidel. Sandwich eil.',
			'SE' => 'Zweden',
			'CH' => 'Zwitserland'
		);
		$output    = self::select( $name, $value, $countries, $args );

		return $output;
	}

	/**
	 * @param             $name
	 * @param string      $value
	 * @param array       $options
	 * @param array       $args
	 *
	 * @return string
	 */
	static function page_select( $name, $value = '', $options = array(), $args = array() ) {
		$args = wp_parse_args( (array) $args, array(
			'id'        => '',
			'class'     => '',
			'post_type' => 'page'
		) );

		$args_pages = array(
			'post_type'        => $args['post_type'],
			'name'             => $name,
			'id'               => $args['id'],
			'selected'         => $value,
			'show_option_none' => __( 'Select a page', $this->text_domain ),
			'echo'             => false
		);

		return wp_dropdown_pages( $args_pages );
	}

	/**
	 * @param       $name
	 * @param       $value
	 * @param array $args
	 *
	 * @return string
	 */
	static function date( $name, $value, $args = array() ) {
		$args = wp_parse_args( (array) $args, array(
			'id'    => '',
			'class' => '',
			'type'  => 'number'
		) );

		$value['d'] = isset( $value['d'] ) ? esc_attr( $value['d'] ) : '';
		$value['m'] = isset( $value['m'] ) ? esc_attr( $value['m'] ) : '';
		$value['y'] = isset( $value['y'] ) ? esc_attr( $value['y'] ) : '';

		$output = self::text( $name . '[d]', $value['d'], $args ) . ' ';
		$output .= self::text( $name . '[m]', $value['m'], $args ) . ' ';
		$output .= self::text( $name . '[y]', $value['y'], $args );

		return $output;
	}


}


?>