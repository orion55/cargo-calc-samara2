<template>
    <form method="POST" class="calc__form">
        <div :class="{'calc':true, 'is-collapse': cargo_form.isCollapse}" id="calc-shipment"
             ref="calc-shipment">
            <div v-show="loading" class="calc__preloader">
                <div class="calc__loader"></div>
            </div>
            <div v-show="!loading">
                <div class="calc__head">
                    <div class="calc__title">Заказ грузового такси
                    </div>
                    <div class="calc__title calc__title--links">
                        <a href="#" class="calc__link--undo hvr-pop" v-if="!cargo_form.isCollapse"
                           @click.prevent="clearData">
                            <i class="fas fa-undo calc__link--indent"></i>
                            <span class="calc__link--text">Очистить</span>
                        </a>
                        <a href="#"
                           class="calc__link--close hvr-pop" v-if="!cargo_form.isCollapse"
                           @click.prevent="closeForm">
                            <i class="fas fa-times-circle"></i>
                        </a>
                    </div>
                </div>
                <div class="calc__megabox">
                    <div class="calc__one">
                        <div class="calc__block">
                            <div class="calc__stage calc__stage--one">
                                <div class="calc__caption calc__caption--one"><span
                                        class="calc__wide">Шаг 1:</span>
                                    Маршрут
                                    и
                                    контакты
                                </div>
                            </div>
                            <div class="calc__row calc__row--one">
                                <div class="calc__item calc__item--one">
                                    <div class="calc__box-select">
                                        <div class="calc__desc">Откуда</div>
                                        <multiselect v-model="address_from.selected"
                                                     :options="address.options"
                                                     label="name" track-by="id" :searchable="false"
                                                     :show-labels="false" :maxHeight="250"
                                                     group-values="area" group-label="place"
                                                     class="calc__dropdown calc__dropdown--from"
                                                     :allow-empty="false" @open="onFocus"
                                                     ref="address_from"></multiselect>
                                    </div>
                                    <div class="calc__address">
                                        <input type="text"
                                               placeholder="Улица" v-model="address_from.street"
                                               :class="{'calc__input': true, 'calc__input--street': true, 'is-danger': errors.has('calc__street-from') }"
                                               name="calc__street-from" @focus="onFocus">
                                        <input type="text" value=""
                                               class="calc__input calc__input--house"
                                               placeholder="Дом" v-model="address_from.house"
                                               @focus="onFocus">
                                        <input type="text" value=""
                                               class="calc__input calc__input--entrance"
                                               placeholder="Под" v-model="address_from.entrance"
                                               @focus="onFocus">
                                    </div>
                                </div>
                                <div class="calc__item calc__item--two">
                                    <div class="calc__box-select">
                                        <div class="calc__desc">Куда</div>
                                        <multiselect v-model="address_to.selected"
                                                     :options="address.options"
                                                     label="name" track-by="id" :searchable="false"
                                                     :show-labels="false" :maxHeight="250"
                                                     group-values="area" group-label="place"
                                                     class="calc__dropdown calc__dropdown--to"
                                                     :allow-empty="false" @open="onFocus"
                                                     ref="address_to"></multiselect>
                                    </div>
                                    <div class="calc__address">
                                        <input type="text" value=""
                                               placeholder="Улица" v-model="address_to.street"
                                               :class="{'calc__input': true, 'calc__input--street': true, 'is-danger': errors.has('calc__street-to') }"
                                               name="calc__street-to" @focus="onFocus">
                                        <input type="text" value=""
                                               class="calc__input calc__input--house"
                                               placeholder="Дом" v-model="address_to.house"
                                               @focus="onFocus">
                                        <input type="text" value=""
                                               class="calc__input calc__input--entrance"
                                               placeholder="Под" v-model="address_to.entrance"
                                               @focus="onFocus">
                                    </div>
                                </div>
                            </div>
                            <div class="calc__row calc__row--two" ref="name_phone">
                                <div class="calc__item calc__item--three">
                                    <label for="calc__name" class="calc__label">Имя</label>
                                    <input id="calc__name" value=""
                                           :class="{'calc__input': true, 'calc__input--name': true, 'is-danger': errors.has('calc__name') }"
                                           placeholder="Представьтесь" v-model="contact.name"
                                           v-validate.disable="'required'"
                                           name="calc__name" @focus="onFocus">

                                </div>
                                <div class="calc__item calc__item--four">
                                    <label for="calc__phone" class="calc__label">Телефон</label>
                                    <input id="calc__phone"
                                           :class="{'calc__input': true, 'calc__input--phone': true, 'is-danger': errors.has('calc__phone') }"
                                           placeholder="Ваш номер" v-model="contact.phone"
                                           ref="phone"
                                           v-validate.disable="'required'" name="calc__phone"
                                           @focus="onFocus">
                                </div>
                            </div>
                            <div class="calc__row calc__row--three">
                                <button type="button" class="btn" @click.prevent="validateContact"
                                        ref="btnContinue"
                                        v-if="formResult">
                                    Продолжить
                                </button>
                                <div class="calc__desc calc__desc--personal" v-else>
                                    Нажимая кнопку «Оформить заказ», вы соглашаетесь
                                    на <a href="#" class="calc__link calc__link--personal">обработку
                                    ваших
                                    персональных
                                    данных</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div :class="{'calc__two': true, 'is-disable': cargo_form.isDisable}">
                        <div class="calc__block">
                            <div class="calc__stage calc__stage--two">
                                <div class="calc__caption calc__caption--two"><span
                                        class="calc__wide">Шаг 2:</span>
                                    Подбор
                                    машины
                                </div>
                            </div>
                            <div class="calc__box calc__box--car">
                                <div class="calc__container">
                                    <div class="calc__wrapper">
                                        <a href="#" class="calc__info-link" @click="openSimplert">
                                            <i class="fas fa-info-circle calc__icon"></i>
                                        </a>
                                        <div class="calc__picture">
                                            <img :src="wp_data.plugin_dir_url + car.selected.picture"
                                                 alt="props.option.name"
                                                 class="calc__img">
                                        </div>
                                        <div class="calc__heading">{{car.selected.name}}</div>
                                    </div>
                                    <div class="calc__selectbox">
                                        <multiselect v-model="car.selected" :options="car.options"
                                                     label="name" track-by="id" :searchable="false"
                                                     :show-labels="false" :maxHeight="270"
                                                     :option-height="58"
                                                     class="calc__dropdown calc__dropdown--selectbox"
                                                     :allow-empty="false">
                                            <template slot="option" slot-scope="props">
                                                <div class="item-down">
                                                    <img :src="wp_data.plugin_dir_url + props.option.picture"
                                                         class="item-down--img"
                                                         :alt="props.option.name"/>
                                                    <div class="item-down--text">{{
                                                        props.option.name }}
                                                    </div>
                                                </div>
                                            </template>
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="calc__holder">
                                    <div class="calc__inner">
                                        <div class="calc__desc calc__desc--cargo">Грузчики</div>
                                        <multiselect v-model="loaders.selected"
                                                     :options="loaders.options"
                                                     label="label" track-by="id" :searchable="false"
                                                     :show-labels="false" :maxHeight="200"
                                                     class="calc__dropdown calc__dropdown--loaders"
                                                     :allow-empty="false"></multiselect>
                                        <div class="calc__desc calc__desc--cargo-time">Время
                                            работы
                                        </div>
                                        <multiselect v-model="cargo_time.selected"
                                                     :options="cargo_options"
                                                     label="label" track-by="id" :searchable="false"
                                                     :show-labels="false" :maxHeight="200"
                                                     class="calc__dropdown calc__dropdown--cargo-time"
                                                     :allow-empty="false"
                                                     :disabled="isDisabledCargoTime"></multiselect>
                                    </div>
                                    <div class="calc__gear-inner">
                                        <label class="control control-checkbox calc__gear-label control__disabled">
                                            Такелажные работы
                                            <input type="checkbox" v-model="riggingFlag"/>
                                            <div class="control_indicator"></div>
                                        </label>
                                        <a href="#" class="calc__gear-link" @click="openRigging">
                                            <i class="fas fa-info-circle calc__icon"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="calc__stage calc__stage--three">
                                <div class="calc__caption calc__caption--three"><span
                                        class="calc__wide">Шаг 3:</span>
                                    получения
                                    скидки
                                </div>
                            </div>
                            <div class="calc__box calc__box--client">
                                <div class="calc__desc calc__desc--client">Номер карты постоянного
                                    клиента
                                </div>
                                <input class="calc__input calc__input--number" ref="card"
                                       v-model="card.serial">
                                <button type="button" class="btn btn--client" ref="btnCheck"
                                        @click.prevent="validateCard">
                                    Проверить
                                </button>
                            </div>
                        </div>
                    </div>
                    <div :class="{'calc__three': true, 'is-disable': cargo_form.isDisable}">
                        <div class="calc__block calc__block--three">
                            <div class="calc__stage calc__stage--four">
                                <div class="calc__caption calc__caption--four"><span
                                        class="calc__wide">Шаг 4:</span>
                                    Время
                                    и
                                    длительность
                                </div>
                            </div>
                            <div class="calc__item calc__item--six">
                                <i class="far fa-calendar-alt calc__icon"></i>
                                <datetime type="datetime" v-model="calendar.datetime"
                                          class='calc__input--datepicker'
                                          :phrases="{ok: 'Ok', cancel: 'Выход'}"
                                          :minute-step="10"
                                          :format="{ year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: '2-digit'}"
                                          value-zone="Europe/Samara" :value="calendar.datetime"
                                ></datetime>
                            </div>
                            <div class="calc__item calc__item--seven">
                                <div class="calc__desc calc__desc--durability">Длительность
                                    заказа
                                </div>
                                <multiselect v-model="durability.selected"
                                             :options="durability_options"
                                             label="label" track-by="id" :searchable="false"
                                             :show-labels="false" :maxHeight="200"
                                             class="calc__dropdown calc__dropdown--durability"
                                             :allow-empty="false"></multiselect>
                            </div>
                            <div class="calc__item calc__item--eight">
                                <a href="#" class="calc__link--plus"
                                   @click.prevent="inverseShowNote">
                                    <i class="fas fa-plus calc__icon calc__plus"></i>
                                    <span class="calc__desc calc__desc--plus">Примечание к заказу</span>
                                </a>
                                <textarea class='calc__input calc__input--note'
                                          v-show="note.visibility"
                                          v-model="note.text"></textarea>
                            </div>
                            <div class="calc__price">
                                <div class="calc__item calc__item--nine">
                                    <span class="calc__price-text">Обычная цена</span>
                                    <span class="calc__price-number"
                                          id="calc__price-number">{{price_normal_common}}</span>
                                    <span class="calc__rub"><i
                                            class="fas fa-ruble-sign calc__price-rub"></i></span>
                                </div>
                                <div class="calc__item calc__item--nine">
                                    <span class="calc__price-text">Грузчики</span>
                                    <span class="calc__price-number"
                                          id="calc__price-movers">{{price_movers}}</span>
                                    <span class="calc__rub"><i
                                            class="fas fa-ruble-sign calc__price-rub"></i></span>
                                </div>
                                <div class="calc__item calc__item--ten">
                                    <div class="calc__box-discount">
                                        <span class="calc__discount">Экономия</span>
                                        <span class="calc__discount-number"
                                              id="calc__discount-number">{{discount}}</span>
                                        <span class="calc__discount-percent">%</span>
                                    </div>
                                    <div class="calc__box-discount-price">
                                                <span class="calc__discount-sum"
                                                      id="calc__discount-sum">{{economy}}</span>
                                        <span class="calc__rub"><i
                                                class="fas fa-ruble-sign calc__discount-rub"></i></span>
                                    </div>
                                </div>
                                <div class="calc__item calc__item--eleven">
                                    <div class="calc__result-text">Итого со скидкой</div>
                                    <div class="calc__box-result-price">
                                        <span class="calc__result-sum"
                                              id="calc__result-sum">{{animated_price_result}}</span>
                                        <span class="calc__rub"><i
                                                class="fas fa-ruble-sign  calc__result-rub"></i></span>
                                    </div>
                                </div>
                                <button type="button" class="btn btn--result hvr-radial-out"
                                        @click.prevent="buttonCheckout.funct"
                                        ref="btnCheckout">
                                    {{buttonCheckout.title}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
  import Multiselect from 'vue-multiselect'
  import _ from 'lodash'
  import { DateTime } from 'luxon'
  import Inputmask from 'inputmask'
  import Datetime from 'vue-datetime'
  import 'vue-datetime/dist/vue-datetime.css'
  import VeeValidate from 'vee-validate'
  import axios from 'axios'
  import { TweenLite } from 'gsap'
  import VueSweetalert2 from 'vue-sweetalert2'

  let Qs = require('qs')

  Vue.component('multiselect', Multiselect)
  Vue.use(Datetime)
  Vue.use(VeeValidate)
  Vue.use(VueSweetalert2)

  //простой расчет цены услуги
  let pricePlus = (obj, durability) => {
    let curPrice = 0
    if (!_.isEmpty(obj)) {
      curPrice += obj.min_price
      if (durability > obj.min_time) {
        curPrice += obj.additional_price * (durability - obj.min_time)
      }
    }
    return curPrice
  }

  //расчёт цены пригорода или Самары
  let priceSuburb = (options) => {
    const {priceData, car_id, address_from_id, address_to_id, durability_id} = options
    let cur = {}
    if (car_id >= 0 && car_id <= 2) {
      cur = _.find(priceData, {
        'car_id': car_id,
        'address_from': address_from_id,
        'address_to': address_to_id,
      })
    } else if (car_id >= 3 && car_id <= 6) {
      cur = _.find(priceData, {'car_id': car_id})
    }
    return pricePlus(cur, durability_id)
  }

  //расчёт междугородней цены
  let priceInterCity = (options) => {
    const {priceData, car_id, address} = options
    let cur = {}
    if (car_id === 2 || car_id === 3) {
      cur = _.find(priceData, {
        'car_id': car_id,
        'address_to': address,
      })
      if (!_.isEmpty(cur)) {
        return cur.price
      }
    }
    return 0
  }

  //добавляем анимацию к объекту
  let animateObj = (obj, className) => {
    obj.classList.add(className)

    setTimeout(function () {
      obj.classList.remove(className)
    }, 1000)
  }

  export default {
    name: 'app',
    components: {
      Multiselect,
    },
    data () {
      return {
        info: {
          data: null,
          loading: true,
          errored: false,
        },
        loaders: {
          selected: {
            id: 0,
            label: 'Нет',
          },
          options: [
            {
              id: 0,
              label: 'Нет',
            },
            {
              id: 1,
              label: '1',
            },
            {
              id: 2,
              label: '2',
            },
            {
              id: 3,
              label: '3',
            },
            {
              id: 4,
              label: '4',
            },
          ],
        },
        cargo_time: {
          selected: {
            id: 0,
            label: 'Нет',
            $isDisabled: false,
          },
          isDisabled: true,
        },
        /* time_delivery: {
           selected: {},
         },*/
        durability: {
          selected: {
            id: 1,
            label: '1 час',
            $isDisabled: false,
          },
        },
        address_from: {
          selected: {},
          street: '',
          house: '',
          entrance: '',
        },
        address_to: {
          selected: {},
          street: '',
          house: '',
          entrance: '',
        },
        address: {
          options: [],
        },
        car: {
          selected: {},
          options: [],
        },
        calendar: {
          datetime: null,
        },
        note: {
          visibility: false,
          text: '',
        },
        objAlertResult: {
          title: '',
          html: '',
          type: '',
          confirmButtonColor: '#90B630',
        },
        contact: {
          name: '',
          phone: '',
        },
        card: {
          serial: '',
        },
        formResult: false,
        discount: 0,
        card_data: null,
        tweened_price_normal: 0,
        cargo_form: {
          isCollapse: true,
          isDisable: false,
        },
        // intercityFlag: false,
        riggingFlag: false,
        loading: true,
        buttonCheckout: {
          title: 'Оформить заказ',
          funct: this.checkout,
        },
      }
    },
    computed: {
      wp_data: function () {
        return window.wp_data
      },
      durability_options: function () {
        //блокировка пунктов меню "длительность заказа"
        //блокируем пункты выпадающего списка в зависимости от типа машины, времени подачи и адреса подачи
        let data = [
          {
            id: 1,
            label: '1 час',
            $isDisabled: false,
          },
          {
            id: 2,
            label: '2 часа',
            $isDisabled: false,
          },
          {
            id: 3,
            label: '3 часа',
            $isDisabled: false,
          },
          {
            id: 4,
            label: '4 часа',
            $isDisabled: false,
          },
          {
            id: 5,
            label: '5 часов',
            $isDisabled: false,
          },
          {
            id: 6,
            label: '6 часов',
            $isDisabled: false,
          },
          {
            id: 7,
            label: '7 часов',
            $isDisabled: false,
          },
          {
            id: 8,
            label: '8 часов',
            $isDisabled: false,
          },
        ]

        if (!_.isEmpty(this.info.data)) {
          const car_id = this.car.selected.id
          const priceData = this.info.data.price

          let current = {}
          if (car_id >= 0 && car_id <= 2) {
            current = _.find(priceData, {
              'car_id': car_id,
              'address_from': this.address_from.selected.id,
              'address_to': this.address_to.selected.id,
            })
          } else if (car_id >= 3 && car_id <= 6) {
            current = _.find(priceData, {'car_id': car_id})
          }

          if (!_.isEmpty(current) && 'min_time' in current) {
            const minTime = +current.min_time - 1
            if (minTime > 0) {
              const part = _.filter(data, (item) => {
                return item.id <= minTime
              })
              _.forEach(part, (item) => {
                item.$isDisabled = true
              })
            }
            this.durability.selected = _.find(data, ['$isDisabled', false])
            /*//если уже установлен заблокированный элемент, меняем на первый за ним незаблокированный
            if (data[this.durability.selected.id - 1].$isDisabled) {
              this.durability.selected = _.find(data, ['$isDisabled', false])
            }*/
          }
        }
        return data
      },
      cargo_options: function () {
        let data = [
          {
            id: 0,
            label: 'Нет',
            $isDisabled: false,
          },
          {
            id: 1,
            label: '1 час',
            $isDisabled: false,
          },
          {
            id: 2,
            label: '2 часа',
            $isDisabled: false,
          },
          {
            id: 3,
            label: '3 часа',
            $isDisabled: false,
          },
          {
            id: 4,
            label: '4 часа',
            $isDisabled: false,
          },
          {
            id: 5,
            label: '5 часов',
            $isDisabled: false,
          },
          {
            id: 6,
            label: '6 часов',
            $isDisabled: false,
          },
          {
            id: 7,
            label: '7 часов',
            $isDisabled: false,
          },
          {
            id: 8,
            label: '8 часов',
            $isDisabled: false,
          },
        ]
        if (!_.isEmpty(this.info.data)) {
          const current = _.find(this.info.data.price_loader, {
            'type_work_id': this.typeWork,
          })
          if (!_.isEmpty(current) && 'min_time' in current) {
            const minTime = +current.min_time - 1
            if (minTime > 0) {
              const part = _.filter(data, (item) => {
                return item.id <= minTime
              })
              _.forEach(part, (item) => {
                item.$isDisabled = true
              })
            }
            //если уже установлен заблокированный элемент, меняем на первый за ним незаблокированный
            if (data[this.cargo_time.selected.id].$isDisabled) {
              this.cargo_time.selected = _.find(data, ['$isDisabled', false])
            }
          }
        }
        return data
      },
      price_normal_common: function () {
        //текущие адреса
        const address_from_id = this.address_from.selected.id
        const address_to_id = this.address_to.selected.id

        //текущий автомобиль
        const car_id = this.car.selected.id

        //длительность заказа
        const durability_id = this.durability.selected.id

        let currentPrice = 0

        if (!_.isEmpty(this.info.data)) {
          //коллекция цен
          const priceData = this.info.data.price

          this.changeBtn(true)

          const options = {
            priceData: priceData,
            car_id: car_id,
            address_from_id: address_from_id,
            address_to_id: address_to_id,
            durability_id: durability_id,
          }

          switch (true) {
            case address_from_id === 999:
              switch (true) {
                case address_to_id === 999:
                  currentPrice += priceSuburb(options)
                  break
                case address_to_id === 998:
                  currentPrice += priceSuburb(options)
                  break
                case address_to_id < 100:
                  currentPrice += priceSuburb(options)
                  break
                case address_to_id >= 100 && address_to_id < 900:
                  currentPrice += priceInterCity({
                    priceData: priceData,
                    car_id: car_id,
                    address: address_to_id,
                  })
                  break
                default:
                  console.log('default999')
              }
              break
            case address_from_id === 998:
              switch (true) {
                case address_to_id === 999:
                  currentPrice += priceSuburb(options)
                  break
                case address_to_id === 998:
                  currentPrice += priceSuburb(options)
                  break
                case address_to_id < 100:
                  currentPrice += priceSuburb(options)
                  break
                case address_to_id >= 100 && address_to_id < 900:
                  currentPrice += priceInterCity({
                    priceData: priceData,
                    car_id: car_id,
                    address: address_to_id,
                  })
                  break
                default:
                  console.log('default998')
              }
              break
            case address_from_id < 100:
              switch (true) {
                case address_to_id === 999:
                  currentPrice += priceSuburb(options)
                  break
                case address_to_id === 998:
                  currentPrice += priceSuburb(options)
                  break
                case address_to_id < 100:
                  currentPrice += priceSuburb(options)
                  break
                case address_to_id >= 100 && address_to_id < 900:
                  currentPrice += priceInterCity({
                    priceData: priceData,
                    car_id: car_id,
                    address: address_to_id,
                  })
                  break
                default:
                  console.log('default<100')
              }
              break
            case address_from_id >= 100 && address_from_id < 900:
              switch (true) {
                case address_to_id === 999:
                  currentPrice += priceInterCity({
                    priceData: priceData,
                    car_id: car_id,
                    address: address_from_id,
                  })
                  break
                case address_to_id === 998:
                  currentPrice += priceInterCity({
                    priceData: priceData,
                    car_id: car_id,
                    address: address_from_id,
                  })
                  break
                case address_to_id < 100:
                  currentPrice += priceInterCity({
                    priceData: priceData,
                    car_id: car_id,
                    address: address_from_id,
                  })
                  break
                case address_to_id >= 100 && address_to_id < 900:

                  break
                default:
                  console.log('default>=100')
              }
              break
            default:
              console.log('default')
          }

          if (currentPrice === 0) {
            this.changeBtn(false)
          }
        }
        return currentPrice
      },
      price_normal: function () {
        return this.price_normal_common + this.price_movers
      },
      price_movers: function () {
        let loaders__price = 0
        if (!_.isEmpty(this.info.data)) {
          const type_work_id = this.typeWork
          //коллекция цен грузчиков
          const priceLoader = this.info.data.price_loader
          //грузчики
          const loaders_id = +this.loaders.selected.id
          const cargo_time_id = this.cargo_time.selected.id

          if (loaders_id !== 0) {
            const current = _.find(priceLoader, {'type_work_id': type_work_id})
            if (!_.isEmpty(current)) {
              loaders__price = current.min_price * loaders_id
              const delta = cargo_time_id - current.min_time
              if (delta > 0) {
                loaders__price += current.additional_price * delta * loaders_id
              }
            }
          }
        }
        return loaders__price
      },
      typeWork: function () {
        //возращает тип работы для грузчиков: город, пригород, такелаж
        let type_work_id = 0
        const address_from_id = this.address_from.selected.id
        const address_to_id = this.address_to.selected.id

        if (this.riggingFlag) {
          type_work_id = 2
        } else if ((address_from_id >= 10 && address_from_id < 100) || (address_to_id >= 10 && address_to_id < 100)) {
          //если адреса из пригорода, но не такелаж, то грузчики - пригород
          type_work_id = 1
        }
        return type_work_id
      },
      economy: function () {
        return Math.round(this.price_normal * this.discount / 100)
      },
      price_result: function () {
        return this.price_normal - this.economy
      },
      animated_price_result: function () {
        return this.tweened_price_normal.toFixed(0)
      },
      isDisabledCargoTime: function () {
        if (typeof this.loaders.selected.id !== 'undefined') {
          if (this.loaders.selected.id === 0) {
            this.cargo_time.selected = {
              id: 0,
              label: 'Нет',
              $isDisabled: false,
            }
          }
          return this.loaders.selected.id === 0
        }
      },
    },
    methods: {
      inverseShowNote: function () {
        this.note.visibility = !this.note.visibility
      },
      openSimplert: function () {
        Vue.swal({
          type: 'info',
          title: this.car.selected.name,
          html: '<div class="calc__modal">' +
            '<div class="calc__modal-desc">' + this.car.selected.desc + '</div>' +
            '<div class="calc__modal-charater">' +
            '<div class="calc__modal-text">Габаритные размеры</div>' +
            '<div class="calc__modal-info">' + this.car.selected.size + '</div>' +
            '<div class="calc__modal-text">Грузоподъемность</div>' +
            '<div class="calc__modal-info">до ' + this.car.selected.carrying + '</div>' +
            '</div></div>',
          confirmButtonColor: '#90B630',
        })

      },
      validateContact () {
        this.$validator.validateAll()
          .then((result) => {
            if (result) {
              this.cargo_form.isCollapse = false
              return
            }

            let btnContinue = this.$refs.btnContinue
            animateObj(btnContinue, 'hvr-buzz-out')
          })
      },
      validateCard () {
        let numberCard = this.card.serial
        numberCard = parseInt(numberCard, 10)
        let serial = this.card_data.serial

        let result = serial.indexOf(numberCard)

        if (result !== -1) {
          animateObj(this.$refs.card, 'is-success')
          this.discount = this.card_data.discount
        } else {
          this.discount = 0
          animateObj(this.$refs.card, 'is-danger')
          animateObj(this.$refs.btnCheck, 'hvr-buzz-out')
        }
      },
      clearData () {
        this.loaders.selected = {
          id: 0,
          label: 'Нет',
        }
        this.cargo_time.selected = {
          id: 0,
          label: 'Нет',
          $isDisabled: false,
        }
        this.durability.selected = {
          id: 1,
          label: '1 час',
          $isDisabled: false,
        }
        this.address_from.selected = {
          'id': 1,
          'name': 'Центральный р-н',
        }
        this.address_from.street = ''
        this.address_from.house = ''
        this.address_from.entrance = ''
        this.address_to.selected = {
          'id': 1,
          'name': 'Центральный р-н',
        }
        this.address_to.street = ''
        this.address_to.house = ''
        this.address_to.entrance = ''
        if (!(_.isEmpty(this.car.options))) {
          this.car.selected = this.car.options[0]
        }
        this.calendar.datetime = DateTime.local().toISO()
        this.note.visibility = false
        this.note.text = ''
        this.contact.name = ''
        this.contact.phone = ''
        this.card.serial = ''
        this.discount = 0
        // this.intercityFlag = false
        this.riggingFlag = false
        _.forEach(this.car.options, (item) => {
          item.$isDisabled = false
        })
      },
      demoData () {
        this.loaders.selected = {
          id: 1,
          label: '1',
        }
        this.cargo_time.selected = {
          id: 0,
          label: 'Нет',
          $isDisabled: false,
        }
        this.durability.selected = {
          id: 1,
          label: '1 час',
          $isDisabled: false,
        }
        // this.address_from.selected = {'id': 1, 'name': 'Центральный р-н'}
        this.address_from.street = 'Республики'
        this.address_from.house = '1'
        this.address_from.entrance = 'а'
        // this.address_to.selected = {'id': 1, 'name': 'Центральный р-н'}
        this.address_to.street = 'Республики'
        this.address_to.house = '2'
        this.address_to.entrance = 'б'
        // this.car.selected = this.car.options[0]
        this.calendar.datetime = DateTime.local().toISO()
        this.note.visibility = false
        this.note.text = 'Срочно, быстро, дешево!'
        this.contact.name = 'Милый Друг'
        this.contact.phone = '+7 (111) 111 11 11'
        this.card.serial = '1111111111'
        this.discount = 5
        this.cargo_form.isCollapse = false
        // this.intercityFlag = false
        this.riggingFlag = false
      },
      closeForm () {
        this.cargo_form.isCollapse = !this.cargo_form.isCollapse
      },
      onFocus () {
        if (this.cargo_form.isCollapse) {
          this.cargo_form.isCollapse = false
        }
      },
      checkout () {
        let data = {
          action: 'cargo_add',
          nonce: this.wp_data.nonce,
          loaders: this.loaders.selected.label,
          cargo_time: this.cargo_time.selected.label,
          // time_delivery: this.time_delivery.selected.name,
          durability: this.durability.selected.label,
          address_from: this.address_from.selected.name,
          address_from_street: this.address_from.street,
          address_from_house: this.address_from.house,
          address_from_entrance: this.address_from.entrance,
          address_to: this.address_to.selected.name,
          address_to_street: this.address_to.street,
          address_to_house: this.address_to.house,
          address_to_entrance: this.address_to.entrance,
          car: this.car.selected.name,
          calendar: this.calendar.datetime,
          note: this.note.text,
          contact_name: this.contact.name,
          contact_phone: this.contact.phone,
          card_serial: this.card.serial,
          price_normal: this.price_normal,
          economy: this.economy,
          discount: this.discount,
          price_result: this.price_result,
          rigging: this.riggingFlag ? 'yes' : 'no',
        }
        this.$validator.validateAll()
          .then((result) => {
            if (result) {
              if (typeof window.yaCounter48348167 !== 'undefined') {
                window.yaCounter48348167.reachGoal('checkout')
              }
              axios.post(this.wp_data.url_ajax, Qs.stringify(data))
                .then((response) => {
                  let answer = response.data
                  if (answer.success) {
                    this.objAlertResult.type = 'success'
                    this.objAlertResult.title = answer.data
                  } else {
                    this.objAlertResult.type = 'error'
                    this.objAlertResult.title = 'Ошибка'
                    this.objAlertResult.html = ''
                    answer.data.forEach((element) => {
                      this.objAlertResult.html += element + '<br />'
                    })
                  }
                  Vue.swal(this.objAlertResult)
                })
                .catch((error) => {
                  Vue.swal({
                    type: 'error',
                    title: 'Ошибка',
                    html: 'Ошибка сервера',
                    confirmButtonColor: '#90B630',
                  })

                })
            } else {
              let btnCheckout = this.$refs.btnCheckout
              animateObj(btnCheckout, 'hvr-buzz-out')
              _.delay(() => {
                if (window.innerWidth <= 768) {
                  this.goto('name_phone')
                }
              }, 1000)
            }
          })
      },
      goto (refName) {
        let element = this.$refs[refName]
        let top = element.offsetTop
        window.scrollTo(0, top)
      },
      fillDestinations () {
        this.address.options.push({
            place: 'Город',
            area: [],
          },
          {
            place: 'Пригород',
            area: [],
          }, {
            place: 'Межгород',
            area: [],
          })
        const curСity = _.find(this.info.data.metadata.area, ['id', 999])
        this.address.options[0].area.push(curСity)

        let filterArray = _.filter(this.info.data.metadata.area, (item) => {
          return item.id >= 10 && item.id < 100
        })
        filterArray = _.sortBy(filterArray, [(item) => {
          return item.name
        }])
        _.forEach(filterArray, (item) => {
          this.address.options[1].area.push(item)
        })

        filterArray = _.filter(this.info.data.metadata.area, (item) => {
          return item.id >= 100 && item.id < 999
        })
        filterArray = _.sortBy(filterArray, [(item) => {
          return item.name
        }])
        _.forEach(filterArray, (item) => {
          this.address.options[2].area.push(item)
        })
        this.address_from.selected = curСity
        this.address_to.selected = curСity
      },
      changeBtn (flag) {
        if (flag) {
          this.buttonCheckout.title = 'Оформить заказ'
          this.buttonCheckout.funct = this.checkout
        } else {
          this.buttonCheckout.title = 'Позвоните менеджеру'
          this.buttonCheckout.funct = this.callManager
          let btnCheckout = this.$refs.btnCheckout
          animateObj(btnCheckout, 'hvr-buzz-out')
        }
      },
      callManager () {
        Vue.swal({
          type: 'info',
          title: '',
          html: 'К сожалению, выбранного направления пока нет, но мы постоянно расширяем список наших маршрутов.<br><br>Позвоните нашему менеджеру по телефонам<br><a href="tel:+78482249060">+7 (8482) 24-90-60</a> <a href="tel:+78003506720">+7 800 350-67-20</a> <br>и узнайте возможно оно уже появилось.',
          confirmButtonColor: '#90B630',
        })

      },
      openRigging () {
        Vue.swal({
          type: 'info',
          title: 'Такелажные работы',
          html: 'это комплекс мер, направленных на поднятие разнообразных грузов с целью их погрузки\\выгрузки.<br><br>Например, нужно перевезти оборудования промышленного назначения, огромные резервуары, банкоматы, сейфы, серверы, контейнеры, пианино и всё, что от 100 кг и больше',
          confirmButtonColor: '#90B630',
        })
      },
    },
    watch: {
      price_result: function (newValue) {
        TweenLite.to(this.$data, 1, {tweened_price_normal: newValue})
      },
    },
    mounted () {
      axios
        .all([axios.get(wp_data.plugin_dir_url + 'assets/json/price.json'),
          axios.get(wp_data.plugin_dir_url + 'assets/json/card.json')])
        .then(axios.spread((response, card_response) => {
          this.info.data = response.data

          //Заполняем список автомобилей
          _.forEach(this.info.data.metadata.car, (item) => {
            item.$isDisabled = false
            this.car.options.push(item)
          })
          this.car.selected = this.car.options[0]

          //Заполняем пункты назначения
          this.fillDestinations()

          //устанавливаем время
          this.calendar.datetime = DateTime.local().toISO()

          //устанавливаем маску телефона
          let im = new Inputmask('+7 (999) 999 99 99')
          im.mask(this.$refs.phone)

          let arr_serial = card_response.data.serial
          // console.log(card_response.data.serial)
          arr_serial = arr_serial.map((num) => parseInt(num, 10))
          arr_serial = _.uniq(arr_serial)
          arr_serial.sort((a, b) => a - b)

          this.card_data = {
            discount: parseInt(card_response.data.discount, 10),
            serial: arr_serial,
          }

          // this.demoData()

          if (this.wp_data.is_full === '1') {
            this.cargo_form.isCollapse = false
          }
        }))
        .catch(error => {
          _.delay(() => {
            this.loading = false
          }, 500)
          console.log('Error:' + error)
          this.info.errored = true
        })
        .finally(() => {
          this.info.loading = false
          _.delay(() => {
            this.loading = false
          }, 500)
        })
    },
  }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style lang="scss">
    @import "./fonts/fonts";
    @import "./fonts/fontawesome";
    @import "./css/base/vars";
    @import "./css/base/smart-grid";
    @import "./css/base/misc";
    @import "./css/base/checkbox";
    @import "./css/base/preloader";
    @import "./css/modules/calc";
</style>
