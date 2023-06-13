<template>
    <div class="chat-box" v-if="show">
        <div class="chat-box-header">
            {{ messages.length == 0 ? 'Ask Our Video Editer' : messages.editer }}
            <button @click="$emit('closemodal')" class="chat-box-toggle">
                <XIcon class=" text-white w-6 h-6">close</XIcon>
            </button>
        </div>
        <div class="chat-box-body">
            <div class="chat-box-overlay">
            </div>
            <div class="chat-logs">
                <div ref="chatContainer"
                    class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
                    <div v-if="messages.length!==0" v-for="reply in messages.messages" :key="reply.id">
                        
                        <div v-if="reply.sent" class="flex justify-end mb-4">
                            <div class="text-sm text-center mt-3 mr-2 text-gray-400">{{ reply.date }}</div>
                            <div
                                class="mr-2 py-3 px-4 bg-primary-400 rounded-bl-3xl rounded-tl-3xl rounded-tr-xl text-white">
                                {{ reply.sent }}
                            </div>
                        </div>
                        <div v-else-if="reply['response']" class="flex justify-start mb-4">

                            <div class="ml-2 py-3 px-4 bg-gray-400 rounded-br-3xl rounded-tr-3xl rounded-tl-xl text-white">
                                {{ reply['response'] }}
                            </div>
                            <div class="text-center mt-3 ml-2 text-gray-400 text-sm">{{ reply['date'] }}</div>

                        </div>

                    </div>
                    <div v-else>
                        <div class="flex justify-center py-20 text-3xl text-gray-400 mb-4">

                            No Messages Yet
                        </div>

                    </div>
                </div>
            </div><!--chat-log -->
        </div>
        <div class="chat-input">
            <form @submit.prevent="store()" class="sticky py-2 px-3 w-full inline-flex">
                <input v-model="form1.message" class="w-full bg-gray-50 py-3 px-3 rounded-xl" type="text"
                    placeholder="type your message here..." />
                <button type="submit"
                    class="inline-flex ml-1 items-center justify-center rounded-lg px-4 py-3 transition duration-500 ease-in-out text-white bg-primary-500 hover:bg-primary-500 focus:outline-none">
                    <PaperAirplaneIcon class="h-6 w-6 ml-0.5 transform rotate-90">Send</PaperAirplaneIcon>
                </button>
            </form>
        </div>
    </div>
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

    if (messages.value.length === 0) {
        form1.message_data.push({ 'sent': form1.message, 'date': moment().format('YYYY-MM-DD hh:mm'), 'read': null })
        form1.post(route('messages.add'), {
            onSuccess: () => {
                getmessages()
                emit('reload_request')
                form1.message = ''
            }
        })
    }
    else {
        messages.value.messages.push({ 'sent': form1.message, 'date': moment().format('YYYY-MM-DD hh:mm'), 'read': null })
        form1.message_data = messages.value.messages

        form1.put(route('messages.send', messages.value.id), {
            onSuccess: () => {
                getmessages()
                emit('reload_request')
                selected_status.value = 'link'
                form1.message = ''
            }
        })
    }

}

watch(() => {
    if (props.show) {
        getmessages()
    }
})
const select_message = (index) => {
    if (messages.value.length!=0) {
        Object.values(messages.value.messages).map((message) => {

            if (message['read'] == null && message['response']) {
                not_readed_messages.value = true
                message['read'] = moment().format('YYYY-MM-DD hh:mm')
            }
        })
        form.messages = messages.value.messages
        form.put(route('messages.send', messages.value.id), {
            onSuccess: () => {
            }
        })
    }


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




const getmessages = () => {
    if (props.show) {
        axios.get(route('messages.get'))
            .then((response) => {
                
                messages.value = response.data
                console.log(messages.value.length==0)
                console.log(messages.value)

                nextTick(() => {
                    select_message(1)
                    // console.log(messages)
                    scrollToBottom();
                })
            })
            .catch((error) => {
                console.error(error)
            })
    }
}

const chatContainer = ref(null)

function scrollToBottom() {
    console.log(chatContainer.value)
    if (chatContainer.value) {
        chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
    }
}
</script>
<style>
#center-text {
    display: flex;
    flex: 1;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;

}

#chat-circle {
    position: fixed;
    bottom: 50px;
    right: 50px;
    background: #558ecbff;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    color: white;
    padding: 28px;
    cursor: pointer;
    box-shadow: 0px 3px 16px 0px rgba(0, 0, 0, 0.6), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
}

.btn#my-btn {
    background: white;
    padding-top: 13px;
    padding-bottom: 12px;
    border-radius: 45px;
    padding-right: 40px;
    padding-left: 40px;
    color: #558ecbff;
}

#chat-overlay {
    background: rgba(255, 255, 255, 0.1);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    /* display: none; */
}


.chat-box {
    /* display: none; */
    background: #efefef;
    position: fixed;
    right: 40px;
    bottom: 80px;
    width: 350px;
    max-width: 85vw;
    max-height: 100vh;
    border-radius: 5px;
    box-shadow: 0px 5px 35px 9px #ccc;
}

.chat-box-toggle {
    float: right;
    margin-right: 15px;
    cursor: pointer;
}

.chat-box-header {
    background: #316ab2ff;
    height: 70px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    color: white;
    text-align: center;
    font-size: 20px;
    padding-top: 17px;
}

.chat-box-body {
    position: relative;
    height: 370px;
    height: auto;
    border: 1px solid #ccc;
    overflow: hidden;
}

.chat-box-body:after {
    content: "";
    opacity: 0.1;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    height: 100%;
    position: absolute;
    z-index: -1;
    background-color: white;
}

#chat-input {
    background: #f4f7f9;
    width: 100%;
    position: relative;
    height: 47px;
    padding-top: 10px;
    padding-right: 50px;
    padding-bottom: 10px;
    padding-left: 15px;
    border: none;
    resize: none;
    outline: none;
    border: 1px solid #ccc;
    color: #888;
    border-top: none;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
    overflow: hidden;
}

.chat-input>form {
    margin-bottom: 0;
}

#chat-input::-webkit-input-placeholder {
    /* Chrome/Opera/Safari */
    color: #ccc;
}

#chat-input::-moz-placeholder {
    /* Firefox 19+ */
    color: #ccc;
}

#chat-input:-ms-input-placeholder {
    /* IE 10+ */
    color: #ccc;
}

#chat-input:-moz-placeholder {
    /* Firefox 18- */
    color: #ccc;
}

.chat-submit {
    position: absolute;
    bottom: 3px;
    right: 10px;
    background: transparent;
    box-shadow: none;
    border: none;
    border-radius: 50%;
    color: #1a2e51ff;
    width: 35px;
    height: 35px;
}

.chat-logs {
    padding: 15px;
    height: 370px;
    overflow-y: scroll;
}

.chat-logs::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    background-color: #F5F5F5;
}

.chat-logs::-webkit-scrollbar {
    width: 5px;
    background-color: #F5F5F5;
}

.chat-logs::-webkit-scrollbar-thumb {
    background-color: #558ecbff;
}



@media only screen and (max-width: 500px) {
    .chat-logs {
        height: 40vh;
    }
}

.chat-msg.user>.msg-avatar img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    float: left;
    width: 15%;
}

.chat-msg.self>.msg-avatar img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    float: right;
    width: 15%;
}

.cm-msg-text {
    background: white;
    padding: 10px 15px 10px 15px;
    color: #666;
    max-width: 75%;
    float: left;
    margin-left: 10px;
    position: relative;
    margin-bottom: 20px;
    border-radius: 30px;
}

.chat-msg {
    clear: both;
}

.chat-msg.self>.cm-msg-text {
    float: right;
    margin-right: 10px;
    background: #5A5EB9;
    color: white;
}

.cm-msg-button>ul>li {
    list-style: none;
    float: left;
    width: 50%;
}

.cm-msg-button {
    clear: both;
    margin-bottom: 70px;
}
</style>
  
<!-- <template>
   
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
                            <div class="text-sm text-center mt-3 mr-2 text-gray-400">{{ reply.date }}</div>
                            <div
                                class="mr-2 py-3 px-4 bg-primary-400 rounded-bl-3xl rounded-tl-3xl rounded-tr-xl text-white">
                                {{ reply.sent }}
                            </div>
                        </div>
                        <div v-else-if="reply['response']" class="flex justify-start mb-4">

                            <div class="ml-2 py-3 px-4 bg-gray-400 rounded-br-3xl rounded-tr-3xl rounded-tl-xl text-white">
                                {{ reply['response'] }}
                            </div>
                            <div class="text-center mt-3 ml-2 text-gray-400 text-sm">{{ reply['date'] }}</div>

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

    if (messages.value.length === 0) {
        form1.message_data.push({ 'sent': form1.message, 'date': moment().format('YYYY-MM-DD hh:mm'), 'read': null })
        form1.post(route('messages.add'), {
            onSuccess: () => {
                getmessages()
                emit('reload_request')
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
    form.put(route('messages.send', selected_message.value.id), {
        onSuccess: () => {
            getmessages()
            select_message(selected_index.value)
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
    Object.values(messages.value[0].messages).map((message) => {

        if (message['read'] == null && message['response']) {
            not_readed_messages.value = true
            message['read'] = moment().format('YYYY-MM-DD hh:mm')
        }
    })
    form.messages = messages.value[0].messages
    form.put(route('messages.send', messages.value[0].id), {
        onSuccess: () => {
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
</script> -->