module.exports = {
  transpileDependencies: ["vuetify"],

  devServer: {
    proxy:{
      "/one":{
        target: "https://api.corona-19.kr/",
        pathRewrite: {'^/one' : ''}
        

      },
      '/two':{
        target: "http://api.openweathermap.org/",
        pathRewrite: {'^/two' : ''}
      },
    

    }
        
    // proxy: {
    //   "https://api.corona-19.kr": {
    //     target: "https://api.corona-19.kr",
    //     changeOrigin: true,
    //     // pathRewrite: {
    //     //   "^/api": "",
    //     // },
    //   },
    },
    // disableHostCheck: true,
    // port: 8000,
    // public: "0.0.0.0:8000",
  
};