import SettingSystem from '../Pages/Settings/System/Index.vue';
import SystemLanguage from '../Pages/Settings/System/Languages/Index.vue';
import SystemLanguageForm from '../Pages/Settings/System/Languages/Index.vue';

export default [{
    path: '/settings/',
    children: [
        {
            path: 'system',
            name: 'settings.system',
            component: SettingSystem,
            children: [{
                    path: '',
                    name: 'settings.system.general',
                    component: () => import("../Pages/Settings/System/General.vue")
                },
                {
                    path: 'email',
                    name: 'settings.system.email',
                    component: () => import("../Pages/Settings/System/Email.vue")
                },
            ]
        },
        {
            path: 'user',
            children: [{
                    path: '',
                    name: 'settings.user.index',
                    component: () => import("../Pages/Settings/User/Index.vue")
                },
                {
                    path: 'create',
                    name: 'settings.user.create',
                    component: () => import("../Pages/Settings/User/Form.vue")
                },
                {
                    path: ':id/edit',
                    name: 'settings.user.edit',
                    component: () => import("../Pages/Settings/User/Form.vue")
                },
            ]
        },
        {
            path: 'permission',
            children: [{
                    path: '',
                    name: 'permission.index',
                    component: () => import("../Pages/Settings/Permission/Index.vue")
                },
                {
                    path: 'create',
                    name: 'permission.create',
                    component: () => import("../Pages/Settings/Permission/Form.vue")
                },
                {
                    path: ':id/edit',
                    name: 'permission.edit',
                    component: () => import("../Pages/Settings/Permission/Form.vue")
                },
            ]
        },
        {
            path: 'department',
            name: 'settings.department',
            component: () => import("../Pages/Settings/Department.vue")
        },
        {
            path: 'job-position',
            name: 'settings.job_position',
            component: () => import("../Pages/Settings/JobPosition.vue")
        },
        {
            path: 'grade',
            name: 'settings.grade',
            component: () => import("../Pages/Settings/Grade.vue")
        },
        {
            path: 'expertise',
            name: 'settings.expertise',
            component: () => import("../Pages/Settings/Expertise.vue")
        },
    ]

}]