<template>
    <div class="mb-4 bg-oceanic flex flex-col justify-between">
        <div class="p-4">
            <a href="{{departmentLink}}"
               class="pb-2 border-b border-oceanic-light text-gray-light link-gray-light text-lg font-medium">
                {{ department.name }}
            </a>
            <div class="flex mt-4">
                <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
                    <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
                         :style="{'background-image': `url(${headAvatarPath}`}"></div>
                </div>
                <div class="ml-4 font-medium">
                    <a href="{{headLink}}" class="mb-1 link-gray-light text-base">
                        {{ department.head.getFullName() }}
                    </a>
                    <div class="text-gray text-xs">{{ department.head.position }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Department} from "../../Department/Department.js";
import {User} from "../User.js";

export default {
    name: "DepartmentPreview",
    props: {
        department: Department
    },

    computed: {
        departmentLink() {
            return `/departments/${this.department.id}/`
        },

        headLink() {
            return `/users/${this.department.head.id}/`
        },

        headAvatarPath() {
            return this.head.avatarPath ? this.head.avatarPath : User.getDefaultAvatarPath()
        }
    }
}
</script>

