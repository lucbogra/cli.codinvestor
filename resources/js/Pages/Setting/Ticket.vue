<script setup>
import { onMounted } from '@vue/runtime-core';
import Setting from './Index.vue';
import FileInput from '../../Components/FileInput.vue';
</script>

<template>
    <Setting title="Profile">
        <template #setting>
            <div class="d_ fd">
                <h3 class="text-xl font-bold">Create a new Ticket</h3>
                <form action="">
                    <div>
                        <label class="block text-sm gp rt" for="default">Subject</label>
                        <input id="default" class="mt-1 block w-full border-gray-300 shadow-md rounded" type="text" placeholder="The subject of your ticket">
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm gp rt" for="default">Are you a file ?</label>
                        <FileInput class="pr-6 pb-8 w-full" type="file" accept=".xlsx, .xls, .csv"/>
                    </div>
                    <div class="">
                        <label class="block text-sm gp rt" for="default">Content</label>
                        <textarea id="feedback" class="f ou xq border-gray-300 shadow-md rounded" rows="4" placeholder="I really enjoy…"></textarea>
                    </div>

                    <div class="mt-4">
                        <button class="w-full bg-sky-800 text-white p-2 rounded shadow-md">Send a Ticket</button>
                    </div>
                </form>
            </div>
        </template>
    </Setting>
</template>
