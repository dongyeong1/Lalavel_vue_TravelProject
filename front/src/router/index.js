import Vue from 'vue'
import VueRouter from 'vue-router'
import Dong from '../views/Dong'
import Yeong from '../views/Yeong'
import Create from '../views/Create'
import Home from '../views/Home'
import Trance from '../views/Trance'
import naverSearch from '../views/naverSearch'
import naverMap from '../views/naverMap'
import weather from '../views/weather'
import calender from '../views/calender'
import resCalender from '../views/resCalender'
import payment from '../views/Payment'
import houseUpload from '../views/houseUpload'
import testview from '../views/testview'
import resHouse from '../views/resHouse'
import VueChart from '@/views/VueChart'
import Chart from '@/components/Chart'
import UserReserve from '@/views/userReserve'
import Paypal from '@/views/paypal'
import login from '@/views/login'
import register from '@/views/register'
import StarChart from '@/views/starChart'
import Main from '@/views/main.vue'
import MyPage from '@/views/myPage'
import HouseSearch from '@/views/houseSearch'
import test from '@/views/tests'
import myPosition from '@/views/myPosition'
import card from '@/views/card.vue'
import jinju from '@/views/jinju.vue'
import MasterHouse from '@/views/masterHouse.vue'
import MasterHouseUpdate from '@/views/masterHouseUpdate.vue'
import qqq from '@/views/qqq.vue'


Vue.use(VueRouter)

const routes=[
    {
        path:'/qqq',
        name:'/qqq',
        component:qqq,
    },
    {
        path:'/masterHouseUpdate',
        name:'/masterHouseUpdate',
        component:MasterHouseUpdate,
        props:true,
    },
    {
        path:'/masterHouse',
        name:'/masterHouse',
        component:MasterHouse,
        props:true
    },
  
    {
        path:'/jinju',
        name:'/jinju',
        component:jinju,
        props:true
    },
    {
        path:'/card',
        name:'/card',
        component:card,
        props:true
    },
    {
        path:'/myPosition',
        name:'/myPosition',
        component:myPosition,
        props:true
    },

    {
        path:'/test',
        name:'/test',
        component:test,
        props:true

    },
    {
        path:'/houseSearch',
        name:'/houseSearch',
        component:HouseSearch,
        props:true
    },
    {
        path:'/myPage',
        name:'/myPage',
        component:MyPage,
        props:true
    },
    {
        path:'/main',
        name:'/Main',
        component:Main,
        props:true

    },
    {
        path:'/StarChart',
        name:StarChart,
        component:StarChart,
    },
    {
        path:'/login',
        name:'/login',
        component:login,
        props:true
    },
    {
        path:'/register',
        name:'/register',
        component:register,
        props:true
    },
    {
        path:'/paypal',
        name:Paypal,
        component:Paypal,
    },
    {
        path:'/userReserved',
        name:UserReserve,
        component:UserReserve,
    },
    {
        path:'/chart',
        name:Chart,
        component:Chart,
    },
    {
        path:'/VueChart',
        name:VueChart,
        component:VueChart,
    },
    {
        path:'/resHouse',
        name:'/resHouse',
        component:resHouse,
        props:true,
    },
    {
        path:'/testview',
        name:testview,
        component:testview,
    },
    {
        path:'/houseUpload',
        name:'/houseUpload',
        component:houseUpload,
        props:true,
    },
    {
        path:'/payMent',
        name:'/payMent',
        component:payment,
        props:true
    },
    {
        path:'/resCalender',
        name:'/resCalender',
        component:resCalender,
        props:true
    },
    {
        path:'/calender',
        name: "/calender",
        component:calender,
        props:true,
    },
    {
        path:'/weather',
        name:weather,
        component:weather,
    },
    {
        path:'/naverMap',
        name:'/naverMap',
        component:naverMap,
        props:true
    },
    {
        path:'/naverSearch',
        name:naverSearch,
        component:naverSearch,
    },

    {
        path:'/home',
        name:Home,
        component:Home
    }
   ,
    {
        path:'/dong',
        name:Dong,
        component:Dong,
    },
    {
        path:'/yeong',
        name:Yeong,
        component:Yeong
    },
    {
        path:'/create',
        name:Create,
        component:Create
    },
    {
        path:'/trance',
        name:Trance,
        component:Trance
    }
]
const router = new VueRouter({
    mode:'history',
    routes
})

export default router