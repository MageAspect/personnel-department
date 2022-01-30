<template>
    <div class="uppercase text-gray-light text-sm">
        <span :class="['flex', 'relative', 'w-fit', 'px-4', {'cursor-pointer': showSort}]" @click="onSort()">
            {{ sortColumnText }}
            <i v-if="showSort"
               :class="['fa-solid', sortDirectionClass, 'absolute', 'right-0    ', 'top-2/4']"
            ></i>
        </span>
    </div>
</template>

<style scoped>
.fa-solid {
    font-size: 10px;
    transform: translateY(-50%);
}
.fa-angle-up, .fa-angle-down {
    opacity: 0.7;
}
</style>

<script>
export default {
    name: "GridHeaderCall",
    emits: ['sort', 'update:sortDirection'],
    props: {
        sortDirection: {
            type: String,
            default: ''
        },
        sortColumnName: {
            type: String,
            default: ''
        },
        sortColumnText: String,
    },

    computed: {
        showSort: function () {
            return this.sortColumnName.length > 0;
        },
        sortDirectionClass: function () {
            switch (this.sortDirection) {
                case 'asc':
                    return 'fa-angle-up';
                case 'desc':
                    return 'fa-angle-down';
                default:
                    return 'hidden'
            }
        }
    },

    methods: {
        onSort() {
            this.$emit('sort', this.sortColumnName, this.getToggledSort());
        },

        getToggledSort() {
            return  this.sortDirection === 'desc' ? 'asc' : 'desc';
        }
    },
}
</script>

