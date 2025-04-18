import { createRouter, createWebHistory } from 'vue-router'
import AuthMiddleware from './Middleware/AuthMiddleware'

import DashboardView from '../Pages/Dashboard.vue';


import ProfileIndex from '../Pages/Profile/Index.vue';
import ProfileEdit from '../Pages/Profile/Edit.vue';
import ProfilePassword from '../Pages/Profile/Password.vue';
import ProfileDevice from '../Pages/Profile/Device.vue';

import SettingRoutes from './settings';
import Login from '../Pages/Auth/Login.vue';

const moduleRoutes = [];

// Dinamis import semua file routes.js dalam folder modules di root
const modules = import.meta.glob("../../../modules/**/resources/routes.js");

// Muat semua rute secara asinkron
const loadModuleRoutes = async () => {
    const routes = await Promise.all(
        Object.keys(modules).map((path) => modules[path]())
    );

    routes.forEach((mod) => {
        moduleRoutes.push(...mod.default);
    });
};

// await loadModuleRoutes();
const router = createRouter({
	history: createWebHistory('/'),
	routes: [
		{ name: 'login', path: '/', component: Login, meta: { layout: 'Guest' } },
		{
			path: '/dashboard',
			name: 'dashboard',
			component: DashboardView,
            meta : {
                requiredAuth : true
            }
		},
        {
          path: '/profile/',
          name: 'profile',
          component: ProfileIndex,
          children : [
              {
                  path: '',
                  name: 'profile.edit',
                  component: ProfileEdit
              },
              {
                  path: 'password',
                  name: 'profile.password',
                  component: ProfilePassword
              },
              {
                  path: 'devices',
                  name: 'profile.device',
                  component: ProfileDevice
              },
              {
                  path: 'additional',
                  name: 'profile.additional',
                  component: () => import("../Pages/Profile/Additional.vue"),
              },
          ],
          meta :{
            requiredAuth : true,
          }
        },
        ...moduleRoutes,
        {
            path: '/employee',
            children: [{
                    path: '',
                    name: 'employee.index',
                    component: () => import("../Pages/Employee/Index.vue"),
                    meta : {
                        requiredAuth : true,
                        permission : 'employee.view',
                    }
                },
                {
                    path: 'create',
                    name: 'employee.create',
                    component: () => import("../Pages/Employee/Form.vue"),
                    meta : {
                        requiredAuth : true,
                        permission : 'employee.create',
                    }
                },
                {
                    path: ':id',
                    name: 'employee.show',
                    component: () => import("../Pages/Employee/Show.vue"),
                    meta : {
                        requiredAuth : true,
                        permission : 'employee.view',
                    }
                },
                {
                    path: ':id/edit',
                    name: 'employee.edit',
                    component: () => import("../Pages/Employee/Form.vue"),
                    meta : {
                        requiredAuth : true,
                        permission : 'employee.update',
                    }
                },
            ]
        },
        ...SettingRoutes,
        {
          path: '/403',
          name: 'forbidden',
          component: () => import('../Pages/Errors/Forbidden.vue'),
          meta: {
              layout: 'Guest'
          }
        },
        {
            path: "/:pathMatch(.*)*",
            name: "not-found",
            component: () => import("../Pages/Errors/NotFound.vue"),
            meta: {
                layout: 'Guest'
            }
        },

	],
})

router.beforeEach(AuthMiddleware);

export default router