const kakao=window.kakao;

class KakaoOverlay{
    constructor(vueMap,content){
        this.content=content;
        this.vueMap=vueMap;
        this.instance=new kakao.maps.CustomOverlay({
            map: null,
            clickable: false,
            content: content,
            position:null,//나중에클릭하면 좌표 바로위에위치시킴
            xAnchor: 0.5,
            yAnchor: 1,
            zIndex: 10
        })
    }

    showAt(lat,lng){
        console.log('overlay show',lat,lng)
        this.instance.setMap(this.vueMap.mapInstance);
        const pos = new kakao.maps.LatLng(lat, lng);
        this.instance.setPosition(pos);
    }
    hide(){
        // console.log(this.instance)
        this.instance.setMap(null)
    }
}

export default KakaoOverlay;