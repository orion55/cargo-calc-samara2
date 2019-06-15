<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://portfolio.infoblog72.ru
 * @since      1.0.0
 *
 * @package    Cargo_Calc
 * @subpackage Cargo_Calc/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cargo_Calc
 * @subpackage Cargo_Calc/public
 * @author     Oleg Grebenev <admin@infoblog72.ru>
 */
class Cargo_Calc_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Cargo_Calc_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Cargo_Calc_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/cargo-calc-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Cargo_Calc_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Cargo_Calc_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/cargo-calc-public.js', array('jquery'), $this->version, false);

    }

    public function cargo_add()
    {
        function contact_send($info)
        {
            $title = 'Новый заказ - ' . $info['contact_name'];
            $headers[] = 'From: master-gruzov.ru <mail@master-gruzov.ru>';
            $headers[] = 'Content-type: text/html; charset=utf-8';

            $email = carbon_get_theme_option('crb_email');
            if (!empty($email)) {
//                $email = 'mastergruzov@gmail.com';

                $message = '<html><body>';
                $message .= '<table rules="all" style="border-color: #666;" cellpadding="10" border="1">';
                $message .= "<tr style='background: #eee;'><td><strong>Имя:</strong> </td><td>" . $info['contact_name'] . "</td></tr>";
                $message .= "<tr><td><strong>Телефон:</strong> </td><td>" . $info['contact_phone'] . "</td></tr>";

                $message .= "<tr style='background: #eee;'><td><strong>Откуда:</strong> </td><td>" . $info['address_from'] . "</td></tr>";
                $message .= "<tr><td><strong>Улица:</strong> </td><td>" . $info['address_from_street'] . "</td></tr>";
                $message .= "<tr><td><strong>Дом:</strong> </td><td>" . $info['address_from_house'] . "</td></tr>";
                $message .= "<tr><td><strong>Подъезд:</strong> </td><td>" . $info['address_from_entrance'] . "</td></tr>";

                $message .= "<tr style='background: #eee;'><td><strong>Куда:</strong> </td><td>" . $info['address_to'] . "</td></tr>";
                $message .= "<tr><td><strong>Улица:</strong> </td><td>" . $info['address_to_street'] . "</td></tr>";
                $message .= "<tr><td><strong>Дом:</strong> </td><td>" . $info['address_to_house'] . "</td></tr>";
                $message .= "<tr><td><strong>Подъезд:</strong> </td><td>" . $info['address_to_entrance'] . "</td></tr>";

//                $message .= "<tr style='background: #eee;'><td><strong>Тип подачи:</strong> </td><td>" . $info['time_delivery'] . "</td></tr>";
                $message .= "<tr><td><strong>Время подачи:</strong> </td><td>" . $info['calendar'] . "</td></tr>";
                $message .= "<tr><td><strong>Длительность заказа:</strong> </td><td>" . $info['durability'] . "</td></tr>";
                $rigg = $info['rigging'] == "yes" ? "Есть" : "Нет";
                $message .= "<tr><td><strong>Такелажные работы:</strong> </td><td>" . $rigg . "</td></tr>";
                $message .= "<tr><td><strong>Примечание:</strong> </td><td>" . $info['note'] . "</td></tr>";

                $message .= "<tr style='background: #eee;'><td><strong>Машина:</strong> </td><td>" . $info['car'] . "</td></tr>";
                $message .= "<tr><td><strong>Грузчики:</strong> </td><td>" . $info['loaders'] . "</td></tr>";
                $message .= "<tr><td><strong>Время работы грузчиков:</strong> </td><td>" . $info['cargo_time'] . "</td></tr>";

                $message .= "<tr><td><strong>Номер карты постоянного клиента:</strong> </td><td>" . $info['card_serial'] . "</td></tr>";

                $message .= "<tr style='background: #eee;'><td><strong>Обычная цена:</strong> </td><td>" . $info['price_normal'] . " руб.</td></tr>";
                $message .= "<tr><td><strong>Размер скидки:</strong> </td><td>" . $info['discount'] . "%</td></tr>";
                $message .= "<tr><td><strong>Сумма скидки:</strong> </td><td>" . $info['economy'] . " руб.</td></tr>";
                $message .= "<tr><td><strong>Итого со скидкой:</strong> </td><td>" . $info['price_result'] . " руб.</td></tr>";

                $message .= "</table>";
                $message .= "</body></html>";

                if (!wp_mail($email, $title, $message, $headers)) {
                    array_push($errorArr, 'Ошибка при отправки письма!');
                }
            } else {
                array_push($errorArr, 'Ошибка при отправки письма! Email отправки не указан!');
            }
        }

        function create_post($info)
        {
            $post_data = array(
                'post_title' => $info['contact_name'] . ' - ' . $info['calendar'],
                'post_content' => $info['contact_name'],
                'post_status' => 'publish',
                'post_type' => 'order_cargo'
            );

            $post_id = wp_insert_post($post_data);

            if (is_wp_error($post_id)) {
                array_push($errorArr, $post_id->get_error_message());
            } else {
                update_post_meta($post_id, '_contact_name', $info['contact_name']);
                update_post_meta($post_id, '_contact_phone', $info['contact_phone']);
                update_post_meta($post_id, '_card_serial', $info['card_serial']);

                update_post_meta($post_id, '_address_from', $info['address_from']);
                update_post_meta($post_id, '_address_from_street', $info['address_from_street']);
                update_post_meta($post_id, '_address_from_house', $info['address_from_house']);
                update_post_meta($post_id, '_address_from_entrance', $info['address_from_entrance']);

                update_post_meta($post_id, '_address_to', $info['address_to']);
                update_post_meta($post_id, '_address_to_street', $info['address_to_street']);
                update_post_meta($post_id, '_address_to_house', $info['address_to_house']);
                update_post_meta($post_id, '_address_to_entrance', $info['address_to_entrance']);

//                update_post_meta($post_id, '_time_delivery', $info['time_delivery']);
                update_post_meta($post_id, '_calendar', $info['calendar']);
                update_post_meta($post_id, '_durability', $info['durability']);
                update_post_meta($post_id, '_note', $info['note']);

                update_post_meta($post_id, '_car', $info['car']);
                update_post_meta($post_id, '_loaders', $info['loaders']);
                update_post_meta($post_id, '_cargo_time', $info['cargo_time']);
                update_post_meta($post_id, '_rigging', $info['rigging']);

                update_post_meta($post_id, '_price_normal', $info['price_normal']);
                update_post_meta($post_id, '_discount', $info['discount']);
                update_post_meta($post_id, '_economy', $info['economy']);
                update_post_meta($post_id, '_price_result', $info['price_result']);
            }
        }

        if (empty($_POST['nonce'])) {
            wp_die('Nonce bad');
        }

        $check_ajax_referer = check_ajax_referer('myajax-nonce123', 'nonce', false);

        if (!$check_ajax_referer) {
            wp_send_json_error('Эх! Сработала защита');
        }

        $info = [];
        $info['address_from'] = sanitize_text_field($_POST['address_from']);
        $info['address_from_entrance'] = sanitize_text_field($_POST['address_from_entrance']);
        $info['address_from_house'] = sanitize_text_field($_POST['address_from_house']);
        $info['address_from_street'] = sanitize_text_field($_POST['address_from_street']);
        $info['address_to'] = sanitize_text_field($_POST['address_to']);
        $info['address_to_entrance'] = sanitize_text_field($_POST['address_to_entrance']);
        $info['address_to_house'] = sanitize_text_field($_POST['address_to_house']);
        $info['address_to_street'] = sanitize_text_field($_POST['address_to_street']);
        $exp = sanitize_text_field($_POST['calendar']);
        $newDate = DateTime::createFromFormat("Y-m-d\TG:i:s.uO", $exp);
        $info['calendar'] = $newDate->format("d.m.Y H:i");
        $info['car'] = sanitize_text_field($_POST['car']);
        $info['card_serial'] = sanitize_text_field($_POST['card_serial']);
        $info['cargo_time'] = sanitize_text_field($_POST['cargo_time']);
        $info['contact_name'] = sanitize_text_field($_POST['contact_name']);
        $info['contact_phone'] = sanitize_text_field($_POST['contact_phone']);
        $info['discount'] = intval($_POST['discount']);
        $info['durability'] = sanitize_text_field($_POST['durability']);
        $info['economy'] = intval($_POST['economy']);
        $info['loaders'] = sanitize_text_field($_POST['loaders']);
        $info['rigging'] = sanitize_textarea_field($_POST['rigging']);
        $info['note'] = sanitize_textarea_field($_POST['note']);
        $info['price_normal'] = intval($_POST['price_normal']);
        $info['price_result'] = intval($_POST['price_result']);
//        $info['time_delivery'] = sanitize_text_field($_POST['time_delivery']);

        $errorArr = [];

        contact_send($info);

        create_post($info);

        if (count($errorArr) > 0) {
            wp_send_json_error($errorArr);
        } else {
            wp_send_json_success('Заказ успешно зарегистрирован!');
        }
        wp_die();
    }

    public function export_csv()
    {

        function fputcsv_eol($fp, $array, $eol)
        {
            fputcsv($fp, $array, ';');
            if ("\n" != $eol && 0 === fseek($fp, -1, SEEK_CUR)) {
                fwrite($fp, $eol);
            }
        }

        function csv_download($array_data, $filename)
        {
            $dir = wp_get_upload_dir();

            $csv_path = $dir['basedir'] . '/csv';

            wp_mkdir_p($csv_path);

            $out = fopen($csv_path . '/' . $filename, 'w');
            fputs($out, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            foreach ($array_data as $row) {
                fputcsv_eol($out, $row, "\r\n");
            }
            fclose($out);
            return $dir['baseurl'] . '/csv/' . $filename;
        }

        function inventory_posts($info)
        {
            $args = array(
                'posts_per_page' => '-1',
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'ASC',
                'post_type' => 'order_cargo',
                'date_query' => array(
                    array(
                        'after' => $info['date_from'],
                        'before' => $info['date_to'],
                        'inclusive' => true,
                    ),
                )
            );

            $out = [];

            $titles = ['Имя', 'Телефон', 'Номер карты', 'Откуда(район)', 'Улица', 'Дом', 'Подъезд',
                'Куда(район)', 'Улица', 'Дом', 'Подъезд', 'Время подачи', 'Длительность заказа', 'Примечание',
                'Машина', 'Грузчики', 'Время работы грузчиков', 'Такелажные работы', 'Обычная цена',
                'Размер скидки %', 'Сумма скидки', 'Итого со скидкой', 'Время заявки'];
            array_push($out, $titles);

            $query = new WP_Query($args);
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $id = get_the_ID();

                    $meta = new stdClass;
                    foreach ((array)get_post_meta($id) as $k => $v) $meta->$k = $v[0];

                    $row = [
                        $meta->_contact_name,
                        $meta->_contact_phone,
                        $meta->_card_serial,

                        $meta->_address_from,
                        $meta->_address_from_street,
                        $meta->_address_from_house,
                        $meta->_address_from_entrance,

                        $meta->_address_to,
                        $meta->_address_to_street,
                        $meta->_address_to_house,
                        $meta->_address_to_entrance,

//                        $meta->_time_delivery,
                        $meta->_calendar,
                        $meta->_durability,
                        $meta->_note,

                        $meta->_car,
                        $meta->_loaders,
                        $meta->_cargo_time,
                        $meta->_rigging,

                        $meta->_price_normal,
                        $meta->_discount,
                        $meta->_economy,
                        $meta->_price_result,

                        get_the_date('d.m.Y H:i')
                    ];

                    array_push($out, $row);
                }
                $file_name = 'csv_file_' . date("dmY_Hi") . '.csv';

                return csv_download($out, $file_name);
            } else {
                array_push($errorArr, 'Записи не найдены!');
            }
            wp_reset_postdata();
        }

        function format_date($date)
        {
            $pieces = explode(".", $date);
            $pieces = array_reverse($pieces);
            return implode("-", $pieces);
        }


        $info = [];
        parse_str($_POST['info'], $info);
        foreach ($info as &$value) {
            $value = sanitize_text_field($value);
        }
        unset($value);

        $errorArr = [];

        $info['date_from'] = format_date($info['date_from']);
        $info['date_to'] = format_date($info['date_to']);

        $result = inventory_posts($info);

        if (count($errorArr) > 0) {
            wp_send_json_error($errorArr);
        } else {
            wp_send_json_success($result);
        }
    }
}
