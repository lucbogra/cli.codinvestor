<script setup>
import { onMounted } from '@vue/runtime-core';
import Setting from './Index.vue';
const props = defineProps({
    packs: Array,
});

onMounted(() => {
    console.log(props.packs)
})
</script>

<template>
    <Setting title="Profile">
        <template #setting>
            <div class="d_ fd">

                <!-- Plans -->
                <section>
                    <div class="rc">
                        <h2 class="gu text-slate-800 font-bold ri">Plans</h2>
                        <div class="text-sm">This marketplace's Basic Plan is set to <strong class="gp">$34</strong> per
                            month.</div>
                    </div>

                    <!-- Pricing -->
                    <div >
                        <!-- Toggle switch -->
                        <div class="flex items-center fl rh">
                            <div class="text-sm text-slate-500 gp">Monthly</div>
                            <div class="c">
                                <input type="checkbox" id="toggle" class="d" x-model="annual">
                                <label class="h_" for="toggle">
                                    <span class="bg-white bv" aria-hidden="true"></span>
                                    <span class="d">Pay annually</span>
                                </label>
                            </div>
                            <div class="text-sm text-slate-500 gp">Annually <span class="yt">(-20%)</span></div>
                        </div>
                        <!-- Pricing tabs -->
                        <div class="sn ag fn">
                            <!-- Tab 1 -->
                            <div v-for="pack in props.packs" :key="pack.id" class="y tz carlos bg-white shadow-md rounded-sm border border-slate-200">
                                <div class="g k x q s_ hd" aria-hidden="true"></div>
                                <div class="vc mb mp cs border-slate-200">
                                    <header class="flex items-center ru">
                                        <div class="oi so rounded-full ub pc pv pz ra">
                                            <svg class="oi so du ye" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 17a.833.833 0 01-.833-.833 3.333 3.333 0 00-3.334-3.334.833.833 0 110-1.666 3.333 3.333 0 003.334-3.334.833.833 0 111.666 0 3.333 3.333 0 003.334 3.334.833.833 0 110 1.666 3.333 3.333 0 00-3.334 3.334c0 .46-.373.833-.833.833z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="ga text-slate-800 gh">{{ JSON.parse(pack.name)['en'] }}</h3>
                                    </header>
                                    <div class="text-sm ru">{{ JSON.parse(pack.description)['en'] }}</div>
                                    <!-- Price -->
                                    <div class="text-slate-800 font-bold ri">
                                        <span class="gu">$</span><span class="text-3xl"
                                            x-text="annual ? '14' : '19'">{{ JSON.parse(pack.price)['en'][0]['amount'] }}</span><span
                                            class="text-slate-500 gp text-sm">/mo</span>
                                    </div>
                                    <!-- CTA -->
                                    <button
                                        class="btn border-slate-200 hover--border-slate-300 g_ ou">Downgrade</button>
                                </div>
                                <div class="vc mc mj">
                                    <div class="go text-slate-800 gh gv ri">What's included</div>
                                    <!-- List -->
                                    <ul>
                                        <li class="flex items-center vf">
                                            <svg class="w-3 h-3 ub du yt mr-2" viewBox="0 0 12 12">
                                                <path
                                                    d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z">
                                                </path>
                                            </svg>
                                            <div class="text-sm">Lorem ipsum dolor sit amet</div>
                                        </li>
                                        <li class="flex items-center vf">
                                            <svg class="w-3 h-3 ub du yt mr-2" viewBox="0 0 12 12">
                                                <path
                                                    d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z">
                                                </path>
                                            </svg>
                                            <div class="text-sm">Quis nostrud exercitation</div>
                                        </li>
                                        <li class="flex items-center vf">
                                            <svg class="w-3 h-3 ub du yt mr-2" viewBox="0 0 12 12">
                                                <path
                                                    d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z">
                                                </path>
                                            </svg>
                                            <div class="text-sm">Lorem ipsum dolor sit amet</div>
                                        </li>
                                        <li class="flex items-center vf">
                                            <svg class="w-3 h-3 ub du yt mr-2" viewBox="0 0 12 12">
                                                <path
                                                    d="M10.28 1.28L3.989 7.575 1.695 5.28A1 1 0 00.28 6.695l3 3a1 1 0 001.414 0l7-7A1 1 0 0010.28 1.28z">
                                                </path>
                                            </svg>
                                            <div class="text-sm">Quis nostrud exercitation</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Contact Sales -->
                <section>
                    <div class="vc vo hm border he rounded-sm gn tru tnp tnz trt tre">
                        <div class="text-slate-800 gh ru tnc">Looking for different configurations?</div>
                        <button class="btn ho xi ye">Contact Sales</button>
                    </div>
                </section>

                <!-- FAQs -->
                <section>
                    <div class="nb">
                        <h2 class="gu text-slate-800 font-bold">FAQs</h2>
                    </div>
                    <ul class="fj">
                        <li>
                            <div class="gh text-slate-800 rt">
                                What is the difference between the three versions?
                            </div>
                            <div class="text-sm">
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit.
                            </div>
                        </li>
                        <li>
                            <div class="gh text-slate-800 rt">
                                Is there any difference between Basic and Plus licenses?
                            </div>
                            <div class="text-sm">
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum in voluptate velit esse cillum dolore eu fugiat nulla
                                pariatur.
                            </div>
                        </li>
                        <li>
                            <div class="gh text-slate-800 rt">
                                Got more questions?
                            </div>
                            <div class="text-sm">
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum in voluptate velit esse cillum dolore eu fugiat <a
                                    class="gp text-indigo-500 xh" href="#0">contact us</a>.
                            </div>
                        </li>
                    </ul>
                </section>

            </div>
        </template>
    </Setting>
</template>
