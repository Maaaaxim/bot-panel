import{_ as i,j as n,b as c,f as e,t as d,n as r,S as m,q as _,s as f}from"./app-0e5c4b28.js";const u={props:{title:{type:String,required:!0},message:{type:String,required:!0},showModal:{type:Boolean,required:!0},cancelText:{type:String,default:"Отмена"},confirmText:{type:String,default:"Подтвердить"}},methods:{closeModal(){this.$emit("update:showModal",!1)},confirmAction(){this.$emit("confirm"),this.closeModal()}}},b=l=>(_("data-v-5e525c3f"),l=l(),f(),l),h={class:"modal-dialog",role:"document"},y={class:"modal-content"},p={class:"modal-header"},M={class:"modal-title",id:"confirmActionModalLabel"},g=b(()=>e("span",{"aria-hidden":"true"},"×",-1)),v=[g],S={class:"modal-body"},x={class:"modal-footer"};function B(l,t,o,C,k,a){return n(),c("div",{class:r(["modal fade",{show:o.showModal}]),tabindex:"-1",role:"dialog","aria-labelledby":"confirmActionModalLabel","aria-hidden":"true",style:m({display:o.showModal?"block":"none"})},[e("div",h,[e("div",y,[e("div",p,[e("h5",M,d(o.title),1),e("button",{type:"button",class:"close","aria-label":"Close",onClick:t[0]||(t[0]=(...s)=>a.closeModal&&a.closeModal(...s))},v)]),e("div",S,d(o.message),1),e("div",x,[e("button",{type:"button",class:"btn btn-secondary",onClick:t[1]||(t[1]=(...s)=>a.closeModal&&a.closeModal(...s))},d(o.cancelText),1),e("button",{type:"button",class:"btn btn-primary",onClick:t[2]||(t[2]=(...s)=>a.confirmAction&&a.confirmAction(...s))},d(o.confirmText),1)])])])],6)}const A=i(u,[["render",B],["__scopeId","data-v-5e525c3f"]]);export{A as B};
