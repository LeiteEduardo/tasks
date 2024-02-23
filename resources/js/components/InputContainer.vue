<template>
    <div class="form-group">
        <label class="form-label" :for="id">{{ title }}</label>
        <slot></slot>
        <div :id="helperId" class="form-text text-sm text-muted">{{ helperText }}</div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'title', 'helperId', 'helperText']
    }
</script>
