const routes = [
    {
        path: '/',
        component: require('../layout/home.vue').default,
        children: [
            {
                path: '',
                component: require('../pages/home/index.vue').default,
                name: 'home'
            },
            {
                path: '/user-account',
                component: require('../layout/user.vue').default,
                name: 'userpanel',
                children: [
                    {
                        path: '',
                        component: require('../pages/user/index.vue').default,
                        name: 'home'
                    },
                    {
                        path: '/profile',
                        component: require('../pages/user/profile.vue').default,
                        name: 'home'
                    },

                ]
            },
        ]
    },
    /*Auth*/
    {
        path: '/login',
        component: require('../pages/auth/login.vue').default,
        name: 'login',
        meta: {
            login: true
        }
    },
    {
        path: '/register',
        component: require('../pages/auth/register.vue').default,
        name: 'login',
        meta: {
            login: true
        }
    },
    {
        path: '/admin',
        component: require('../layout/admin.vue').default,
        meta: {
            admin: true,
        },
        name: 'admin',
        children: [
            {
                path: '/',
                component: require('../pages/admin/dashboard/index.vue').default,
                name: 'dashbord',
            },
            {
                path: 'users',
                component: require('../pages/admin/users/index.vue').default,
                name: 'users',
            },
            {
                path: 'users/update/:id/:name',
                component: require('../pages/admin/users/update.vue').default,
                name: 'usersupdate',
            },
            {
                path: 'category',
                component: require('../pages/admin/category/index.vue').default,
                name: 'category',
            },
            {
                path: 'category/create',
                component: require('../pages/admin/category/create.vue').default,
                name: 'category-create',
            },
        ]
    },
    /* 404 Page */
    {
        path: '/404',
        component: require('../error/notfound').default,
        name: 'not-found'
    },
    {
        path: '*',
        component: require('../error/notfound').default,
        redirect: '/404'
    },

]

export default routes;




