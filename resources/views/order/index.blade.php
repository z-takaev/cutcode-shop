@extends('layouts.app')

@section('content')
    <!-- Breadcrumbs -->
    <ul class="breadcrumbs flex flex-wrap gap-y-1 gap-x-4 mb-6">
        <li><a href="{{ route('home') }}" class="text-body hover:text-pink text-xs">Главная</a></li>
        <li><a href="{{ route('cart') }}" class="text-body hover:text-pink text-xs">Корзина покупок</a></li>
        <li><span class="text-body text-xs">Оформление заказа</span></li>
    </ul>

    <section>
        <!-- Section heading -->
        <h1 class="mb-8 text-lg lg:text-[42px] font-black">Оформление заказа</h1>

        <form class="grid xl:grid-cols-3 items-start gap-6 2xl:gap-8 mt-12">

            <!-- Contact information -->
            <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                <h3 class="mb-6 text-md 2xl:text-lg font-bold">Контактная информация</h3>
                <div class="space-y-3">
                    <input type="text"
                           class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                           placeholder="Имя" required>
                    <input type="text"
                           class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                           placeholder="Фамилия" required>
                    <input type="text"
                           class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                           placeholder="Номер телефона" required>
                    <input type="email"
                           class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                           placeholder="E-mail" required>
                    <div x-data="{ createAccount: false }">
                        <div class="py-3 text-body">Вы можете создать аккаунт после оформления заказа</div>
                        <div class="form-checkbox">
                            <input type="checkbox" id="checkout-create-account">
                            <label for="checkout-create-account" class="form-checkbox-label"
                                   @click="createAccount = ! createAccount">Зарегистрировать аккаунт</label>
                        </div>
                        <div
                            x-show="createAccount"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="mt-4 space-y-3"
                        >
                            <input type="password"
                                   class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                                   placeholder="Придумайте пароль" required>
                            <input type="password"
                                   class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                                   placeholder="Повторите пароль" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping & Payment -->
            <div class="space-y-6 2xl:space-y-8">

                <!-- Shipping-->
                <div x-data="{ type: 'pickup' }" class="p-6 2xl:p-8 rounded-[20px] bg-card">
                    <h3 class="mb-6 text-md 2xl:text-lg font-bold">Способ доставки</h3>
                    <div class="space-y-5">
                        <div class="form-radio">
                            <input x-model="type" type="radio" name="delivery-method[]" value="pickup" id="delivery-method-pickup">
                            <label for="delivery-method-pickup" class="form-radio-label">Самовывоз</label>
                        </div>
                        <div class="space-y-3">
                            <div class="form-radio">
                                <input x-model="type" type="radio" name="delivery-method[]" value="courier" id="delivery-method-address">
                                <label for="delivery-method-address" class="form-radio-label">Курьером</label>
                            </div>
                            <input x-show="type === 'courier'"
                                   type="text"
                                   class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                                   placeholder="Город" required>
                            <input x-show="type === 'courier'"
                                   type="text"
                                   class="w-full h-16 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                                   placeholder="Адрес" required>
                        </div>
                    </div>
                </div>

                <!-- Payment-->
                <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                    <h3 class="mb-6 text-md 2xl:text-lg font-bold">Метод оплаты</h3>
                    <div class="space-y-5">
                        <div class="form-radio">
                            <input type="radio" name="payment-method[]" id="payment-method-1" checked>
                            <label for="payment-method-1" class="form-radio-label">Наличными</label>
                        </div>
                        <div class="form-radio">
                            <input type="radio" name="payment-method[]" id="payment-method-2">
                            <label for="payment-method-2" class="form-radio-label">Кредитной картой</label>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Checkout -->
            <div class="p-6 2xl:p-8 rounded-[20px] bg-card">
                <h3 class="mb-6 text-md 2xl:text-lg font-bold">Заказ</h3>
                <table class="w-full border-spacing-y-3 text-body text-xxs text-left" style="border-collapse: separate">
                    <thead class="text-[12px] text-body uppercase">
                    <th scope="col" class="pb-2 border-b border-body/60">Товар</th>
                    <th scope="col" class="px-2 pb-2 border-b border-body/60">К-во</th>
                    <th scope="col" class="px-2 pb-2 border-b border-body/60">Сумма</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td scope="row" class="pb-3 border-b border-body/10">
                            <h4 class="font-bold"><a href="product.html"
                                                     class="inline-block text-white hover:text-pink break-words pr-3">SteelSeries
                                    Aerox 3 Snow</a></h4>
                            <ul>
                                <li class="text-body">Цвет: Белый</li>
                                <li class="text-body">Размер (хват): Средний</li>
                            </ul>
                        </td>
                        <td class="px-2 pb-3 border-b border-body/20 whitespace-nowrap">2 шт.</td>
                        <td class="px-2 pb-3 border-b border-body/20 whitespace-nowrap">87 800 ₽</td>
                    </tr>
                    </tbody>
                </table>

                    <!-- Summary -->
                    <table class="w-full text-left">
                        <tbody>
                        <tr>
                            <th scope="row" class="text-md 2xl:text-lg font-black">Итого:</th>
                            <td class="text-md 2xl:text-lg font-black">245 930 ₽</td>
                        </tr>
                        </tbody>
                    </table>

                    <!-- Process to checkout -->
                    <button type="submit" class="mt-4 w-full btn btn-pink">Оформить заказ</button>
                </div>
            </div>

        </form>
    </section>
@endsection
