<template>
    <a 
    :class="activeClasses"
    :href="'#'" 
    class="nav-link" href="#"> {{ link.navi }} </a>
</template>

<script>
    export default{
        props:['link','isActive'],
        computed: {
            activeClasses(){
                return {
                    "bg-gray-100 bg-transparent text-blue-700": this.isActive,
                    emphasize: this.isActive
                }
            }
        }
    }
</script>

<style scoped>
.emphasize{
    text-decoration: underline !important;
}
</style>