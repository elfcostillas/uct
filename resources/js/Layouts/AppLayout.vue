<template>
    <div class="m-2 gap-2">
        <nav>
            <slot name="nav" />
        </nav>
        <header class="m-4">     
            <slot name="header" />
        </header>   
        <div class="flex my-0 mx-4 gap-4"> 
            <div class="w-80">
                <section>
                    <slot name="section" />
                </section>
            </div>
            <div style="width:100%">
                <main>
                    <slot name="main" />    
                </main>
            </div>
           
        </div>

        <slot name="dialog" /> 

        <footer>
             <slot name="footer" />

        </footer>
       
    </div>
    
</template>

<script setup>

</script>

<style lang="css">

body {
    /* background-color: #ececec; */
    background-color: #e7e4c9;
    font-size: 10pt;
}

</style>