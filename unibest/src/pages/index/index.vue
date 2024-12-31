<!-- 使用 type="home" 属性设置首页，其他页面不需要设置，默认为page；推荐使用json5，更强大，且允许注释 -->
<route lang="json5" type="home">
{
  layout: 'tabbar',
  style: {
    navigationStyle: 'custom',
    navigationBarTitleText: '首页',
  },
}
</route>

<template>
  <view class="container">
    <view class="main-box">
      <!--蒙版-->
      <view v-show="modalStatus" class="mio-modal-mask" @click="handleClose"></view>
      <!--首页-->
      <view class="bg">
        <image :src="gy" />
        <view class="box">
          <view class="yuanpan">
            <image :src="yuanpan" />
            <view class="xuanzhun">
              <image :src="guang" />
            </view>
            <view class="gyimg">
              <image :src="guanyin" />
            </view>
          </view>
        </view>
        <view class="btn-box">
          <view class="kaishi">
            <image :src="kaishi" />
          </view>
          <view class="lot w-[100px] h-[40px]">
            <image @click="lot" style="animation: scale-upOne 2s infinite linear" :src="ksBtn" />
          </view>
        </view>
        <!--抽签动画-->
        <view v-if="qianStatus" class="qianhe-box">
          <view class="qianhe w-[110px] h-[180px]">
            <image :src="qt" />
            <view class="getQian2 w-[25px] h-[100px]">
              <image style="z-index: 88" :src="qian" />
            </view>
          </view>
        </view>
      </view>

      <!--抽到的签文-->
      <view v-if="getQian" class="qianwen-box flex justify-center items-center flex-col">
        <view class="qianImg-box w-[200px] h-[400px]">
          <view class="left w-[80px] h-[20px]">
            <image :src="downFive" />
          </view>
          <view class="right w-[80px] h-[20px]">
            <image :src="downFour" />
          </view>
          <image :src="qianImg" />
        </view>
        <!-- <view></view> -->
        <!-- <view>
          <image :src="ssq" />
        </view> -->
        <view class="w-[180px] h-[50px] mt-4" @click="chakan">
          <image :src="ck" />
        </view>
      </view>
    </view>
  </view>
</template>

<script lang="ts" setup>
import { getIsTabbar, currRoute } from '@/utils'
// import { useNavbarStore } from '@/store'
import { onShow } from '@dcloudio/uni-app'
import { httpGet, httpPost } from '@/utils/http'
// const navbarStore = useNavbarStore()
const prayInfo = ref<any>({})
onShow(() => {})

// 微信不支持这种写法，我是cv改的
const downFour = '/static/images/pray/download-4.png'
const downFive = '/static/images/pray/download-5.png'
const ssq = '/static/images/pray/shangshangqian.png'
const ck = '/static/images/pray/chakan.png'
const gy = '/static/images/pray/gy_bj@2x.png'
const yuanpan = '/static/images/pray/yuanpan@2x.png'
const guang = '/static/images/pray/guang@2x.png'
const guanyin = '/static/images/pray/guanyin_new@2x.png'
const kaishi = '/static/images/pray/kaishi_bj@2x.png'
const ksBtn = '/static/images/pray/kaishi_btn@2x.png'
const qt = '/static/images/pray/qiantong.png'
const qian = '/static/images/pray/qian.png'

// 响应式状态
const qianStatus = ref(false)
const show = ref(false)
const modalStatus = ref(false)
const qianImg = ref('')
const getQian = ref(false)
const num = ref(0)
const info = ref<any>({})

// 方法
const lot = () => {
  modalStatus.value = true
  qianStatus.value = true
  console.log('num', num)
  num.value = randomNum(1, 2)
  console.log('随机数', num.value)
  httpGet<any>('/guanyin/getById', {
    id: num.value,
  }).then((res) => {
    console.log('抽签', res)
    qianImg.value = res.data.href
    info.value = res.data
  })
  // qianImg.value = `/static/images/pray/qian/q${num.value}.png`

  setTimeout(() => {
    qianStatus.value = false
    getQian.value = true
  }, 1500)
}

const handleClose = () => {
  modalStatus.value = false
  getQian.value = false
}

const chakan = () => {
  console.log('解签', info.value)
}
const randomNum = (min, max) => {
  return Math.floor(Math.random() * (max - min + 1)) + min
}
</script>

<style lang="scss" scoped>
image {
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
}
.container {
  // 自己计算 我随意给的
  height: calc(100vh - 50px);
}
.main-box {
  height: 100%;
  overflow: hidden;
  .bg {
    position: relative;
    width: 100%;
    height: 100%;
    image {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .box {
      position: absolute;
      top: 50%;
      left: 50%;
      display: flex;
      justify-content: center;
      width: 300px;
      height: 500px;
      margin-top: 20px;
      transform: translate(-50%, -50%);
      .yuanpan {
        position: relative;
        top: 0;
        width: 200px;
        height: 200px;
        .xuanzhun {
          position: absolute;
          top: -50px;
          left: -50px;
          width: 300px;
          height: 300px;
          transition-duration: 1s;
          transition-property: -webkit-transform;
          animation: 6s linear 0s infinite normal none running rotate;
        }
        .gyimg {
          position: absolute;
          top: 50px;
          left: -50px;
          width: 300px;
          height: 400px;
        }
      }
    }
    .btn-box {
      position: absolute;
      bottom: 0;
      left: 0;

      display: flex;
      justify-content: center;
      width: 100%;
      height: 200px;
      .kaishi {
        width: 380px;
        height: 100%;
      }
      .lot {
        position: absolute;
        bottom: 1%;

        animation: scale-upOne 2s infinite linear;
      }
    }

    .qianhe-box {
      position: absolute;
      top: 50%;
      left: 50%;
      z-index: 889;
      display: flex;
      justify-content: center;
      width: 100%;
      height: 200px;
      transform: translate(-50%, -50%);
      .qianhe {
        position: relative;
        transform-origin: center bottom;
        animation: qianhe 1s linear 0s;
        .getQian2 {
          position: absolute;
          top: 20px;
          right: 30px;
          opacity: 0;
          animation: qianAnimation 1s linear 1s;
        }
      }
    }
  }
  .qianwen-box {
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 900;
    transform: translate(-50%, -50%);
    animation: cq_two 1.5s linear;
    .qianImg-box {
      position: relative;
      .left {
        position: absolute;
        top: 0;
        left: -80px;
        animation: yuncai1 2s linear infinite;
      }
      .right {
        position: absolute;
        right: -80px;
        bottom: 0;
        animation: yuncai2 2s linear infinite;
      }
    }
  }
}

.mio-modal-mask {
  position: fixed;
  top: 0px;
  right: 0px;
  bottom: 0px;
  left: 0px;
  z-index: 888;
  visibility: visible;
  background: rgba(0, 0, 0, 0.6);
  opacity: 1;
  transition: all 0.3s ease-in-out 0s;
}
@keyframes scale-upOne {
  0% {
    opacity: 1;
    transform: scale(1);
  }
  25% {
    opacity: 1;
    transform: scale(1.1);
  }
  50% {
    opacity: 1;
    transform: scale(1.2);
  }
  75% {
    opacity: 1;
    transform: scale(1.1);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

@keyframes rotate {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(359deg);
  }
}

@keyframes qianhe {
  0% {
    transform: rotate(0deg);
  }
  4.25% {
    transform: rotate(-15deg);
  }
  8.25% {
    transform: rotate(0deg);
  }
  12.5% {
    transform: rotate(15deg);
  }
  16.5% {
    transform: rotate(0deg);
  }
  20.5% {
    transform: rotate(-15deg);
  }
  24.75% {
    transform: rotate(0deg);
  }
  28.75% {
    transform: rotate(15deg);
  }
  33% {
    transform: rotate(0deg);
  }
  37% {
    transform: rotate(-15deg);
  }
  41.25% {
    transform: rotate(0deg);
  }
  45.25% {
    transform: rotate(15deg);
  }
  49.5% {
    transform: rotate(0deg);
  }
  53.5% {
    transform: rotate(-15deg);
  }
  57.75% {
    transform: rotate(0deg);
  }
  61.75% {
    transform: rotate(15deg);
  }
  66% {
    transform: rotate(0deg);
  }
  70% {
    transform: rotate(-15deg);
  }
  74.25% {
    transform: rotate(0deg);
  }
  78.25% {
    transform: rotate(15deg);
  }
  82.5% {
    transform: rotate(0deg);
  }
  86.5% {
    transform: rotate(-15deg);
  }
  90.75% {
    transform: rotate(0deg);
  }
  94.75% {
    transform: rotate(15deg);
  }
  100% {
    transform: rotate(0deg);
  }
}

@keyframes qianAnimation {
  0% {
    opacity: 0.3;

    transform: rotate(0deg);
  }
  10% {
    top: 30px;
    right: 0px;
    opacity: 0.5;

    transform: rotate(90deg);
  }
  20% {
    top: 60px;
    right: -30px;

    transform: rotate(180deg);
  }
  30% {
    top: 90px;
    right: -60px;

    transform: rotate(270deg);
  }
  40% {
    top: 120px;
    right: -90px;

    transform: rotate(360deg);
  }
  50% {
    top: 150px;
    right: -120px;

    transform: rotate(450deg);
  }
  60% {
    top: 180px;
    right: -150px;

    transform: rotate(540deg);
  }
  70% {
    top: 210px;
    right: -180px;
    opacity: 1;

    transform: rotate(630deg);
  }
  80% {
    top: 240px;
    right: -210px;
    opacity: 1;

    transform: rotate(720deg);
  }
  90% {
    top: 280px;
    right: -250px;
    opacity: 1;

    transform: rotate(810deg);
  }
  100% {
    top: 320px;
    right: -300px;
    opacity: 1;

    transform: rotate(900deg);
  }
}

.mio-modal-mask {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 888;
  visibility: visible;
  background: rgba(0, 0, 0, 0.6);
  opacity: 1;
  transition: all 0.3s ease-in-out;
}

@keyframes yuncai1 {
  0% {
    left: -80px;
  }
  50% {
    left: -100px;
  }
  100% {
    left: -80px;
  }
}

@keyframes yuncai2 {
  0% {
    right: -80px;
  }
  50% {
    right: -100px;
  }
  100% {
    right: -80px;
  }
}

@keyframes cq_two {
  from {
    top: 100%;
  }
  to {
    top: 50%;
  }
}

@keyframes slide-top {
  0% {
    opacity: 1;
    transform: translateY(0.1rem);
  }

  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
