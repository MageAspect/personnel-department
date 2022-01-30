<template>
    <form class="group relative">
        <svg width="20" height="20" fill="currentColor"
             class="absolute left-3 top-1/2 -mt-2.5 text-gray-light
                    pointer-events-none
                    group-focus-within:text-blue-500"
             aria-hidden="true">
            <path fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414
                             1.414l-4.816-4.816A6 6 0 012 8z"/>
        </svg>
        <input @input.prevent="onSearchInput($event.target.value)"
               class="transition focus:ring-2 focus:ring-blue-dark focus:outline-none
                      w-64 text-sm leading-6 bg-oceanic-light w-full
                      text-gray-light placeholder-gray-400 rounded-sm
                      py-2 pl-10 ring-1 ring-gray-200 shadow-sm"
               type="text"
               :placeholder="placeholder">
    </form>
</template>

<script>
export default {
    name: "search",
    emits: ['search'],
    props: {
        placeholder: String
    },

    methods: {
        onSearchInput(search) {
            if (search !== '' && search.length < 3) {
                return;
            }

            clearTimeout(this.searchInputTimeout);
            this.searchInputTimeout = setTimeout(
                () => {this.$emit('search', search)},
                500
            )
        }
    }
}
</script>

<style scoped>

</style>
