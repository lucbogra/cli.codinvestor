<template>
    <div v-if="show"
        class="fixed flex flex-col z-50 bottom-[100px] top-0 right-0 left-0 sm:top-auto sm:right-5 sm:left-auto h-[calc(100%-95px)] w-full sm:w-[350px] overflow-auto min-h-[250px] sm:h-[600px] border border-gray-300 bg-white shadow-2xl rounded-md"
        @close="$emit('closemodal')">
        <div v-if="selected_status !== 'create'" class="flex flex-row max-h-6/12 justify-between h-full bg-white">
            <div class="flex-1 justify-between flex flex-col h-screen">
                <div class="inline-flex sticky px-4 justify-between bg-primary-400 py-6 text-center">
                    <div v-if="messages && messages.length > 0" class="font-semibold text-white text-xl">
                        Video Editer
                    </div>
                    <button @click="$emit('closemodal')" type="button">
                        <XIcon class="t text-white w-5 h-5" />
                    </button>
                </div>
                <div
                    class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
                    <div v-if="messages && messages.length > 0" v-for="reply in messages[0].messages" :key="reply.id">
                        <div v-if="reply.sent" class="flex justify-end mb-4">
                            <div class="text-center mt-3 mr-2 text-gray-400">{{ reply.date }}</div>
                            <div
                                class="mr-2 py-3 px-4 bg-primary-400 rounded-bl-3xl rounded-tl-3xl rounded-tr-xl text-white">
                                {{ reply.sent }}
                            </div>
                        </div>
                        <div v-else-if="reply['response']" class="flex justify-start mb-4">

                            <div class="ml-2 py-3 px-4 bg-gray-400 rounded-br-3xl rounded-tr-3xl rounded-tl-xl text-white">
                                {{ reply['response'] }}
                            </div>
                            <div class="text-center mt-3 ml-2 text-gray-400">{{ reply['date'] }}</div>

                        </div>

                    </div>
                    <div v-else>
                        <div class="flex justify-center py-20 text-3xl text-gray-400 mb-4">

                            No Messages Yet
                        </div>

                    </div>
                </div>
                <div class="py-5 ">
                    <form @submit.prevent="store()" class="sticky py-6 px-3 w-full inline-flex">
                        <input v-model="form1.message" class="w-full bg-gray-50 py-3 px-3 rounded-xl" type="text"
                            placeholder="type your message here..." />
                        <!-- <button  type="submit" class="rotate-90">
                            <PaperAirplaneIcon class="h-8 w-8 text-gray-400" />
                        </button> -->
                        <button type="submit"
                            class="inline-flex ml-1 items-center justify-center rounded-lg px-4 py-3 transition duration-500 ease-in-out text-white bg-primary-400 hover:bg-primary-500 focus:outline-none">
                            <span class="font-bold">Send</span>
                            <PaperAirplaneIcon class="h-6 w-6 ml-2 transform rotate-90" />
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
    <!-- <input ref="input"> -->
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { nextTick, onMounted, ref, watch } from 'vue';
import { PaperAirplaneIcon, XIcon, ChevronDoubleDownIcon } from '@heroicons/vue/outline'
import moment from 'moment'
onMounted(() => {

    getmessages()
    selected_status.value = props.status
    // props.show ?  : ''
})

const props = defineProps({
    show: Boolean,
    request: Object,
    status: String
})
const emit = defineEmits('reload_request')
const form = useForm({
    messages: ''
})

const form1 = useForm({
    message: '',
    // request_id: '',
    message_data: []
})
const selected_status = ref('')
const message = ref(null)
const selected_index = ref(null)
const messages = ref([]);
const selected_message = ref([]);
const count_read = ref(0)
const not_readed_messages = ref(false)


const store = () => {

    // form1.request_id = props.request.id
    if (messages.value.length === 0) {
        form1.message_data.push({ 'sent': form1.message, 'date': moment().format('YYYY-MM-DD hh:mm'), 'read': null })
        form1.post(route('messages.add'), {
            onSuccess: () => {
                getmessages()
                emit('reload_request')
                // selected_status.value='link'
                form1.message = ''
            }
        })
    }
    else {
        messages.value[0].messages.push({ 'sent': form1.message, 'date': moment().format('YYYY-MM-DD hh:mm'), 'read': null })
        form1.message_data = messages.value[0].messages

        form1.put(route('messages.send', messages.value[0].id), {
            onSuccess: () => {
                getmessages()
                emit('reload_request')
                selected_status.value = 'link'
                form1.message = ''
            }
        })
    }

}


const submit = () => {
    selected_message.value.messages.push({ 'sent': message.value }, { 'date': moment().format('YYYY-MM-DD hh:mm') }, { 'read': null })

    form.messages = selected_message.value
    // console.log();
    form.put(route('messages.send', selected_message.value.id), {
        onSuccess: () => {
            getmessages()
            select_message(selected_index.value)
            // selected_message.value = messages.value[index]
            //  = index
            message.value = ''
        }
    })
}

watch(() => {
    if (props.show) {
        getmessages()
    }
})
const select_message = (index) => {
    // console.log('before ' )
    // selected_message.value =

    Object.values(messages.value[0].messages).map((message) => {

        if (message['read'] == null && message['response']) {
            not_readed_messages.value=true
            message['read'] = moment().format('YYYY-MM-DD hh:mm')
        }
    })
    form.messages = messages.value[0].messages
    form.put(route('messages.send', messages.value[0].id), {
        onSuccess: () => {
            // getmessages
        }
    })

}

const counRead = (message) => {
    count_read.value = 0
    message.messages.map((item) => {
        if (item['read'] == null && item['response']) {
            count_read.value += 1
        }
    })
    return count_read.value;
}

// const scrollToBottom=(()=>{
//     const conversation = conversationRef.value
//     conversation.scrollTop = conversation.scrollHeight
// })

const getmessages = () => {
    if (props.show) {
        axios.get(route('messages.get'))
            .then((response) => {
                messages.value = response.data

                nextTick(() => {
                    select_message(1)

                })
            })
            .catch((error) => {
                console.error(error)
            })
    }


}
</script>
<style></style>
