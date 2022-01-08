export class User {
    id;
    name;
    lastName;
    patronymic;
    email;
    phone;
    position;
    avatarPath;
    profileUrl;
    salary;

    /**
     *
     * @param obj
     * @return {User}
     */
    static fromJson(obj) {
        let u = new User();
        u.id = obj.id;
        u.name = obj.name ? obj.name : '';
        u.lastName = obj.lastName ? obj.lastName : '';
        u.patronymic = obj.patronymic ? obj.patronymic : '';
        u.phone = obj.phone ? obj.phone : '';
        u.email = obj.email ? obj.email : '';
        u.position = obj.position ? obj.position : '';
        u.avatarPath = obj.avatar ? obj.avatar : '/img/user/user-plug.svg';
        u.profileUrl = obj.profileUrl ? obj.profileUrl : '';
        u.salary = obj.salary ? obj.salary : null;

        return u;
    }

    clone() {
        let cloned = new User();

        cloned.id = this.id;
        cloned.name = this.name;
        cloned.lastName = this.lastName;
        cloned.patronymic = this.patronymic;
        cloned.phone = this.phone;
        cloned.email = this.email;
        cloned.position = this.position;
        cloned.avatarPath = this.avatarPath;
        cloned.profileUrl = this.profileUrl;
        cloned.salary = this.salary
        return cloned;
    }
}
