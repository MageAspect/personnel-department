export class User {
    id;
    name;
    lastName;
    email;
    phone;
    position;
    avatarPath;
    profileLink;

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
        u.phone = obj.phone ? obj.phone : '';
        u.position = obj.position ? obj.position : '';
        u.avatarPath = obj.avatarPath ? obj.avatarPath : '';
        u.profileLink = obj.profileLink ? obj.profileLink : '';

        return u;
    }

    clone() {
        let cloned = new User();

        cloned.id = this.id;
        cloned.name = 'Борис';
        cloned.lastName = this.lastName;
        cloned.phone = this.phone;
        cloned.position = this.position;
        cloned.avatarPath = this.avatarPath;
        cloned.profileLink = this.profileLink;

        return cloned;
    }
}
