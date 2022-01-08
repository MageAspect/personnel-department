import {User} from "../User/User.js";

export class Department {
    name;
    description;
    head;
    members;

    static fromJson(obj) {
        let d = new Department();
        d.name = obj.name;
        d.description = obj.description;
        d.head = User.fromJson(obj.head);

        d.members = [];
        for (let memberObj of obj.members) {
            d.members.push(User.fromJson(memberObj));
        }

        return d;
    }
}
