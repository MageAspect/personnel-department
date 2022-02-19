export class JournalEntry {
    /** @type {String} */
    position;

    /** @type {String} */
    departmentName;

    /** @type {Number} */
    salary;

    /** @type {Date} */
    startedAt;

    /** @type {Date|null} */
    endedAt;

    /**
     * @return {number}
     */
    getDurationInDays() {
        if (!this.startedAt) {
            return 0;
        }

        let endedAt = this.endedAt ? this.endedAt : new Date();

        const startedAtUTC = Date.UTC(this.startedAt.getFullYear(), this.startedAt.getMonth(), this.startedAt.getDate());
        const endedAtUTC = Date.UTC(endedAt.getFullYear(), endedAt.getMonth(), endedAt.getDate());

        return Math.floor((endedAtUTC - startedAtUTC) / (1000 * 60 * 60 * 24));
    }

    static fromJson(jsonJournal) {
        let j = new JournalEntry();
        j.position = jsonJournal.position;
        j.departmentName = jsonJournal.departmentName;
        j.salary = jsonJournal.salary; 

        j.startedAt = jsonJournal.startedAt ? new Date(jsonJournal.startedAt) : null;
        j.endedAt = jsonJournal.endedAt ? new Date(jsonJournal.endedAt) : null;

        return j;
    }
}
