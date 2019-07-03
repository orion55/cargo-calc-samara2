<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'crb_attach_theme_options');
function crb_attach_theme_options()
{
    Container::make('theme_options', __('Опции калькулятора', 'crb'))
        ->set_icon('dashicons-businessman')
        ->set_page_menu_title('Калькулятор')
        ->set_page_menu_position(7)
        ->add_fields(array(
            Field::make('html', 'crb_information_text')
                ->set_html('<div><b>[cargo-calc-samara]</b> - шорткод для вставки калькулятора<br>
            <b>[cargo-calc-samara full="1"]</b> - развёрнутый вид калькулятора         
            </div>'),
            Field::make('text', 'crb_email', 'Email')
                ->set_help_text('Email для отправки заказов')
        ));

    Container::make('post_meta', __('Опции заказа', 'crb'))
        ->where('post_type', '=', 'order_cargo')
        ->add_fields(array(
                Field::make('text', 'contact_name', 'Имя')
                    ->set_attribute('type', 'text')
                    ->set_required(true)
                    ->set_width(33),
                Field::make('text', 'contact_phone', 'Телефон')
                    ->set_attribute('type', 'tel')
                    ->set_attribute('placeholder', '+7 (***) ***-**-**')
                    ->set_required(true)
                    ->set_width(33),
                Field::make('text', 'card_serial', 'Номер карты постоянного клиента')
                    ->set_attribute('type', 'text')
                    ->set_attribute('placeholder', '*****-*****')
                    ->set_width(33),

                Field::make('text', 'address_from', 'Откуда (район)')
                    ->set_attribute('type', 'text')
                    ->set_width(40),
                Field::make('text', 'address_from_street', 'Улица')
                    ->set_attribute('type', 'text')
                    ->set_width(40),
                Field::make('text', 'address_from_house', 'Дом')
                    ->set_attribute('type', 'text')
                    ->set_width(10),
                Field::make('text', 'address_from_entrance', 'Подъезд')
                    ->set_attribute('type', 'text')
                    ->set_width(10),

                Field::make('text', 'address_to', 'Куда (район)')
                    ->set_attribute('type', 'text')
                    ->set_width(40),
                Field::make('text', 'address_to_street', 'Улица')
                    ->set_attribute('type', 'text')
                    ->set_width(40),
                Field::make('text', 'address_to_house', 'Дом')
                    ->set_attribute('type', 'text')
                    ->set_width(10),
                Field::make('text', 'address_to_entrance', 'Подъезд')
                    ->set_attribute('type', 'text')
                    ->set_width(10),
                /*Field::make('text', 'time_delivery', 'Тип подачи')
                    ->set_attribute('type', 'text')
                    ->set_width(25),*/
                Field::make('date_time', 'calendar', 'Время подачи')
                    ->set_storage_format("d.m.Y H:i")
                    ->set_input_format('d.m.Y H:i', 'd.m.Y H:i')
                    ->set_width(33),
                Field::make('text', 'durability', 'Длительность заказа')
                    ->set_attribute('type', 'text')
                    ->set_width(33),
                Field::make('checkbox', 'rigging', 'Такелажные работы')
                    ->set_width(33)
                    ->set_classes('rigging-checkbox'),

                Field::make('textarea', 'note', 'Примечание')
                    ->set_rows(2)
                    ->set_width(100),

                Field::make('text', 'car', 'Машина')
                    ->set_attribute('type', 'text')
                    ->set_width(33),
                Field::make('text', 'loaders', 'Грузчики')
                    ->set_attribute('type', 'text')
                    ->set_width(33),
                Field::make('text', 'cargo_time', 'Время работы грузчиков')
                    ->set_attribute('type', 'text')
                    ->set_width(33),

                Field::make('text', 'price_normal', 'Обычная цена')
                    ->set_attribute('type', 'number')
                    ->set_attribute('min', '0')
                    ->set_width(25),
                Field::make('text', 'discount', 'Размер скидки')
                    ->set_attribute('type', 'number')
                    ->set_attribute('min', '0')
                    ->set_width(25),
                Field::make('text', 'economy', 'Сумма скидки')
                    ->set_attribute('type', 'number')
                    ->set_attribute('min', '0')
                    ->set_width(25),
                Field::make('text', 'price_result', 'Итого со скидкой')
                    ->set_attribute('type', 'number')
                    ->set_attribute('min', '0')
                    ->set_width(25)
            )
        );
}
