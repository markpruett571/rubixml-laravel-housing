<script setup>
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
    import {Head, router, useForm} from '@inertiajs/vue3';
    import {ref} from "vue";

    const props = defineProps(['houseSale']);
    const form = useForm({...props.houseSale});
    const estimating = ref(false);

    const estimatePrice = () => {
        estimating.value = true;

        axios.post(route('estimate-house-sale-price', form.id));
    };

    Echo.channel('house-sales')
        .listen('HouseSalePriceEstimated', (e) => {
            router.visit(route('house-sales.edit', props.houseSale.id), {
                only: ['houseSale']
            });
        });
</script>

<template>
    <Head title="House Sale"/>

    <AuthenticatedLayout>
        <!-- Design from https://preline.co/examples/application-form-layouts.html -->
        <div class="max-w-4xl px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                    Estimated Price
                </h2>

                <div v-if="estimating">
                    Estimating...
                </div>

                <div v-if="houseSale.estimated_price">
                    {{ houseSale.estimated_price }}
                </div>

                <button @click="estimatePrice" class="mt-4 py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                    Estimate
                </button>
            </div>
        </div>

        <!-- Card Section -->
        <div class="max-w-4xl px-4 sm:px-6 lg:px-8 mx-auto mt-4">
            <!-- Card -->
            <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                        House Sale {{ houseSale.id }}
                    </h2>
                </div>

                <form>
                    <!-- Grid -->
                    <div class="grid grid-cols-12 gap-4 sm:gap-6">
                        <div class="col-span-3">
                            <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                Price
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="price" type="number" v-model="form.price" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                House ID
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="house_id" type="number" v-model="form.house_id" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="date" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                Date
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="date" type="date" v-model="form.date" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="bedrooms" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                Bedrooms
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="bedrooms" type="number" step="0.5" v-model="form.bedrooms" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="bathrooms" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                Bathrooms
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="bathrooms" type="number" step="0.5" v-model="form.bathrooms" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="sqft_living" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                SqFt Living
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="sqft_living" type="number" v-model="form.sqft_living" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="sqft_lot" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                SqFt Lot
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="sqft_lot" type="number" v-model="form.sqft_lot" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="floors" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                Floors
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="floors" type="number" v-model="form.floors" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="waterfront" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                Waterfront
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="waterfront" type="number" v-model="form.waterfront" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="view" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                View
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="view" type="number" v-model="form.view" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="condition" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                Condition
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="condition" type="number" v-model="form.condition" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="grade" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                Grade
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="grade" type="number" v-model="form.grade" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="yr_built" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                Yr Built
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="yr_built" type="number" v-model="form.yr_built" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="yr_renovated" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                Yr Renovated
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="yr_renovated" type="number" v-model="form.yr_renovated" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="zipcode" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                Zipcode
                            </label>
                        </div>

                        <div class="col-span-9">
                            <div class="flex items-center gap-5">
                                <div class="flex gap-x-2">
                                    <input id="zipcode" type="number" v-model="form.zipcode" class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm -mt-px -ml-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-l-lg sm:mt-0 sm:first:ml-0 sm:first:rounded-tr-none sm:last:rounded-bl-none sm:last:rounded-r-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Grid -->

                    <div class="mt-5 flex justify-end gap-x-2">
                        <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                            Cancel
                        </button>
                        <button type="button" class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800">
                            Save changes
                        </button>
                    </div>
                </form>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Card Section -->
    </AuthenticatedLayout>
</template>
