<template>
    <div v-if="pagesCount > 1" class="w-full flex justify-center py-4">
        <div class="flex items-center">
            <template v-for="pageNumber in pagesCount">
                <button v-if="pageNumber !== currentPage"
                        :disabled="isPageChangeDisabled"
                        class="text-gray font-light text-sm px-2 py-1"
                        @click="$emit('changePage', pageNumber)"
                >
                    {{ pageNumber }}
                </button>
                <button v-else
                        :disabled="isPageChangeDisabled"
                        class="cursor-default font-light text-sm px-2 py-1 bg-blue text-white"
                >
                    {{ pageNumber }}
                </button>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    name: "GridPagination",
    emits: ['changePage'],

    props: {
        isPageChangeDisabled: Boolean,
        recordsTotalCount: Number,
        currentPage: Number,
        recordsPerPage: Number
    },

    computed: {
        pagesCount: function () {
            if (this.recordsTotalCount % this.recordsPerPage === 0) {
                return this.recordsTotalCount / this.recordsPerPage;
            }

            return Math.floor(this.recordsTotalCount / this.recordsPerPage) + 1;
        }
    }

}
</script>

