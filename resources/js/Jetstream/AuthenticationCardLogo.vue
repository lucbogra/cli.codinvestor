<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Link :href="'/'">
        <img class="w-32" alt="logo" :src="$page.props.logo_color" />
    </Link>
</template>
