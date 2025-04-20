/*
 * Main and demo navigation arrays
 */

export default {
    main: [
        {
            name: "base.dashboard",
            to: "/dashboard",
            icon: "fluent:home-24-regular",
            // permission : 'dashboard.view'
        },
        {
            name: "base.employee",
            to: "/employee",
            icon: "fluent:people-24-regular",
            permission: "employee.view",
        },
        {
            name: "base.setting",
            icon: "solar:settings-linear",
            subActivePaths: "/settings/",
            sub: [
                {
                    name: "base.system",
                    to: "/settings/system",
                    permission: "",
                },
                {
                    name: "base.user",
                    to: "/settings/user",
                    permission: "user.view",
                },
                {
                    name: "base.role_permission",
                    to: "/settings/permission",
                    permission: "role.view",
                },
                {
                    name: "base.department",
                    to: "/settings/department",
                    permission: "department.view",
                },
                {
                    name: "base.job_position",
                    to: "/settings/job-position",
                    permission: "job_position.view",
                },
                {
                    name: "base.grade",
                    to: "/settings/grade",
                    permission: "grade.view",
                },
                {
                    name: "base.expertise",
                    to: "/settings/expertise",
                    permission: "expertise.view",
                },
            ],
        },
    ],
};
