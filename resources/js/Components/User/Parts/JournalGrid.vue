<template>
    <div class="grid gap-y-6 gap-x-9 journal-grid ui-x-scroll pb-6">
        <div class="text-sm uppercase text-gray-light">Должность</div>
        <div class="text-sm uppercase text-gray-light">Отдел</div>
        <div v-if="displaySalary" class="text-sm uppercase text-gray-light">Оклад</div>
        <div class="text-sm uppercase text-gray-light">Срок в должности</div>
        <div class="text-sm uppercase text-gray-light">Дата вступления</div>
        <div class="text-sm uppercase text-gray-light">Дата выхода из должности</div>
        <template v-for="entry of entries">
            <div class="text-gray-light text-sm font-light">{{ entry.position }}</div>
            <div class="text-gray-light text-sm font-light">{{ entry.departmentName ? entry.departmentName : '—' }}</div>
            <div class="text-gray-light text-sm font-light">{{ getFormattedSalary(entry.salary) }}</div>
            <div class="text-gray-light text-sm font-light">{{ getFormattedInDays(entry.getDurationInDays()) }}</div>
            <div class="text-gray-light text-sm font-light">{{ getFormattedStartedAt(entry.startedAt) }}</div>
            <div class="text-gray-light text-sm font-light">{{ getFormattedEndedAt(entry.endedAt) }}</div>
        </template>
    </div>

</template>

<style scoped>
.journal-grid {
        grid-template-columns: repeat(6, max-content);
}
</style>

<script>

export default {
    name: "JournalGrid",

    props: {
        entries: Array,
        displaySalary: Boolean
    },

    methods: {
        getFormattedSalary(salary) {
            salary = new Intl.NumberFormat().format(salary);

            return `${salary} руб.`;
        },

        /**
         *
         * @param {Number} daysIs
         * @return {string}
         */
        getFormattedInDays(daysIs) {
            let langPostfix = 'дней';

            if (daysIs % 10 === 1) {
                langPostfix = 'день';
            }
            if ([2, 3, 4].includes(daysIs % 10)) {
                langPostfix = 'дня';
            }

            return `${daysIs} ${langPostfix}`
        },

        /**
         *
         * @param {Date} startedAt
         * @return {string|null}
         */
        getFormattedStartedAt(startedAt) {
            let month = startedAt.getUTCMonth() + 1;
            month = month < 10 ? `0${month}` : month;

            return startedAt ? `${startedAt.getDate()}.${month}.${startedAt.getUTCFullYear()}`
                : null;
        },

        /**
         *
         * @param {Date} endedAt
         * @return {string|null}
         */
        getFormattedEndedAt(endedAt) {
            return endedAt ? `${endedAt.getDate()}.${endedAt.getUTCMonth()}.${endedAt.getUTCFullYear()}`
                : 'До сих пор в должности';
        }
    },
}

</script>
