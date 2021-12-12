const kakao=window.kakao

class MarkerHandler {
    constructor(vueKakaoMap,options){
        console.log(vueKakaoMap);
        this.vueKakaoMap=vueKakaoMap
        this.options=options;
       
        
    }

    //  markerList=[];
    
    
    add(userData,fnConv){
        
        userData.forEach(data=>{
            // marker.setMap(null)
            const option =fnConv(data);

            // const markerInstance=new kakao.maps.Marker()
            const markerInstance = new kakao.maps.Marker({
                map: this.vueKakaoMap.mapInstance,
                position: new kakao.maps.LatLng(option.lat, option.lng),
               
            });
            // markerInstance.setMap(map);
            // this.markerList.push(markerInstance)
            data.abc='dong'
            console.log('data',data)
           
            markerInstance.$$={
                data,
            };
          

            if(this.options.markerClicked){
                kakao.maps.event.addListener(markerInstance,"click",()=>{
                    this.options.markerClicked(markerInstance.$$.data);
                    // this.options.markerRemove()
                })
            }
           
            console.log('마커')
            console.log(markerInstance);

             
        
           
        })
     
        
    }
    clear(){
       
       
        // console.log(this.markerList) 
        // this.markerList.forEach(a=>{
        //     a.setMap(null);
        //     // console.log(this.markerList) 
        // })
            
        // for (var i = 0; i < 2; i++) {
        //     this.markerList[i].setMap(null);
        //     console.log(i)
        // }           
        // console.log(this.markerList) 
        
    }
}

export default MarkerHandler