import {User} from "../User/User.js";

export class Department {
    /** @type {Number} */
    id;
    /** @type {String} */
    name;
    /** @type {String} */
    description;
    /** @type {User} */
    head;
    /** @type {User[]} */
     members;

    static fromJson(obj) {
        let d = new Department();
        d.id = obj.id;
        d.name = obj.name;
        d.description = obj.description;
        d.head = User.fromJson(obj.head);

        d.members = [];
        for (let memberObj of Object.values(obj.members)) {
            d.members.push(User.fromJson(memberObj));
        }

        return d;
    }
}
