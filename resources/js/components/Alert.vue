<template>
    <div :class="style" role="alert">
        {{ title }}: {{ details.message }}
    </div>
</template>

<script>
    export default {
        props: ['type', 'title', 'details'],
        computed: {
            style() {
                return 'alert alert-' + this.type
            }
        }
    }
</script>
