import{r as v,A as k,j as o,b as u,f as d,t as h,H as q,I as $,F as m,J as _,c as b,u as f,K as C,M as N,N as P,_ as S,e as w,d as z,O as I,n as M,o as A,g as y,p as O,x as B,a as x}from"./app-0e5c4b28.js";const j={class:"text-right mb-3 mr-3 col-md-auto"},L={method:"get"},V=["value"],U={name:"TablePerPageSelect",props:{options:{type:Array,required:!0},value:{type:Number,default:null},perPageText:{type:String,default:null}},emits:["update:value"],setup(t,{emit:r}){const e=t,i=v(null);k(()=>e.value,a=>{a!==null?i.value=a:e.options.length>0&&(i.value=e.options[0],r("update:value",i.value))},{immediate:!0});const s=a=>{i.value=parseInt(a.target.value,10),r("update:page-size",i.value)};return(a,l)=>(o(),u("div",j,[d("form",L,[d("label",null,h(t.perPageText),1),q(d("select",{class:"form-control","onUpdate:modelValue":l[0]||(l[0]=n=>i.value=n),onChange:s},[(o(!0),u(m,null,_(e.options,n=>(o(),u("option",{key:n,value:n},h(n),9,V))),128))],544),[[$,i.value]])])]))}};function T(t,r){if(t)t=typeof t=="string"?t:String(t);else return"";return t.length>r?t.substring(0,r)+"...":t}const E={name:"TableItem",props:{data:{type:Object,required:!0},limit:{type:String,required:!0},action:{type:String,required:!0},id:{type:Number,required:!0}},setup(t){const r=t,e=b(()=>T(r.data,r.limit));return(i,s)=>h(f(e))}},H={name:"TableItemCheckBox",props:{data:{type:Object,required:!0},limit:{type:String,required:!0},action:{type:String,required:!0},id:{type:Number,required:!0}},setup(t){const r=t,e=b(()=>r.data===1);return(i,s)=>q((o(),u("input",{type:"checkbox","onUpdate:modelValue":s[0]||(s[0]=a=>N(e)?e.value=a:null),disabled:""},null,512)),[[C,f(e)]])}},R=["onClick"],D={name:"TableItemLink",props:{data:{type:Object,required:!0},limit:{type:String,required:!0},action:{type:String,required:!0},id:{type:Number,required:!0}},emits:["handle"],setup(t,{emit:r}){const e=t,i=b(()=>T(e.data,parseInt(e.limit,10)));function s(){e.action&&r("handle",{action:e.action,id:e.id,data:e.data})}return(a,l)=>(o(),u("a",{href:"#",onClick:P(s,["prevent"])},h(f(i)),9,R))}},J={name:"TableItemDeleteButton",props:{data:{type:Object,required:!0},limit:{type:String,required:!0},action:{type:String,required:!0},id:{type:Number,required:!0}},emits:["handle"],setup(t,{emit:r}){const e=t;function i(){e.action&&r("handle",{action:e.action,id:e.id,data:e.data})}return(s,a)=>(o(),u("button",{type:"button",class:"btn btn-block btn-danger",onClick:i}," Удалить "))}};const K={class:"links-container"},G=["onClick"],Q={key:0,class:"divider"},W={name:"TableItemLinkArray",props:{data:{type:Object,required:!0},limit:{type:String,required:!0},action:{type:String,required:!0},id:{type:Number,required:!0}},emits:["handle"],setup(t,{emit:r}){const e=t;function i(s){console.log("handle: ",s),e.action&&r("handle",{action:e.action,id:s,data:s})}return(s,a)=>(o(),u("div",K,[(o(!0),u(m,null,_(t.data,(l,n,p)=>(o(),u("span",{key:n},[d("a",{href:"#",onClick:P(g=>i(l),["prevent"])},h(l),9,G),p<Object.keys(t.data).length-1?(o(),u("span",Q," | ")):w("",!0)]))),128))]))}},X=S(W,[["__scopeId","data-v-6e84329d"]]);const Y={class:"col-sm-12"},Z={class:"table-wrapper"},F={class:"table table-hover text-nowrap"},ee={name:"TableMainPart",props:{columns:{type:Array,required:!0},data:{type:Array,required:!0}},emits:["handle"],setup(t,{emit:r}){const e={default:E,checkbox:H,link:D,button:J,arrayLink:X};function i(a){return e[a]||e.default}function s(a){r("handle",a)}return(a,l)=>(o(),u("div",Y,[d("div",Z,[d("table",F,[d("thead",null,[d("tr",null,[(o(!0),u(m,null,_(t.columns,n=>(o(),u("th",{key:n.key},h(n.label),1))),128))])]),d("tbody",null,[(o(!0),u(m,null,_(t.data,n=>(o(),u("tr",{key:n.id},[(o(!0),u(m,null,_(t.columns,p=>(o(),u("td",{key:p.key,class:"bot-table-td"},[(o(),z(I(i(p.type)),{data:n[p.key],limit:p.limit,action:p.action,id:n.id,onHandle:s},null,40,["data","limit","action","id"]))]))),128))]))),128))])])])]))}},te=S(ee,[["__scopeId","data-v-157c297d"]]),ae={class:"col-sm-12 col-md-7"},ne={class:"dataTables_paginate paging_simple_numbers"},re={class:"pagination"},se=["onClick"],ie={name:"TablePagination",props:{currentPage:{type:Number,required:!0},totalPages:{type:Number,required:!0}},emits:["changePage"],setup(t,{emit:r}){const e=t;function i(a){a>0&&a<=e.totalPages&&a!==e.currentPage&&r("update:page-change",a)}function s(){const a=[],l=e.currentPage,n=e.totalPages,p=1;l>2&&a.push({page:1,text:"1",active:!1}),l>p+2&&a.push({text:"...",active:!1});for(let g=Math.max(1,l-p);g<=Math.min(n,l+p);g++)a.push({page:g,text:`${g}`,active:l===g});return l<n-(p+1)&&a.push({text:"...",active:!1}),l<n&&n>2&&a.push({page:n,text:`${n}`,active:!1}),a}return(a,l)=>(o(),u("div",ae,[d("div",ne,[d("nav",null,[d("ul",re,[(o(!0),u(m,null,_(s(),n=>(o(),u("li",{class:M(["page-item",{active:n.active}]),key:n.text},[d("a",{class:"page-link",href:"#",onClick:P(p=>i(n.page),["prevent"])},h(n.text),9,se)],2))),128))])])])]))}},oe={class:"card-body"},ue={id:"example2_wrapper",class:"dataTables_wrapper dt-bootstrap4"},le={class:"row"},ce={class:"row"},de={class:"row"},he={name:"BotsTable",props:{users:Boolean,columns:Array,data:Array,totalPages:Number,currentPage:Number,nextPage:Number,previousPage:Number,pageSizeOptions:{type:Array,default:()=>[10,25,50,100]},perPageText:String,perPage:Number},emits:["update:page-size-change","update:page-change","handle"],setup(t,{emit:r}){const e=t;function i(c){r("handle",c)}const s=v(e.perPage||e.pageSizeOptions[0]),a=v(e.currentPage||1),l=O(),n=B();A(()=>{const c=n.query;c.page&&c.page!==a.value&&g(Number(c.page)),c.perPage&&c.perPage!==s.value&&p(Number(c.perPage))}),k([s,a],()=>{const c={};s.value!==10&&(c.perPage=s.value),a.value!==1&&(c.page=a.value),l.replace({path:n.path,query:c})});const p=c=>{s.value=c,r("update:page-size-change",c)},g=c=>{a.value=c,r("update:page-change",c)};return(c,pe)=>(o(),u("div",oe,[d("div",ue,[d("div",le,[y(U,{perPageText:t.perPageText,options:t.pageSizeOptions,value:s.value,"onUpdate:pageSize":p},null,8,["perPageText","options","value"])]),d("div",ce,[y(te,{columns:t.columns,data:t.data,onHandle:i},null,8,["columns","data"])]),d("div",de,[y(ie,{"total-pages":t.totalPages,"current-page":a.value,"onUpdate:pageChange":g},null,8,["total-pages","current-page"])])])]))}};function me(t,r=null,e=null){const i=v(1),s=v(10);return{currentPage:i,pageSize:s,handlePageChange:n=>{i.value=n,r?r(e):t(x.changePage,{page:n}),window.scrollTo({top:0,left:0,behavior:"smooth"})},handlePageSizeChange:n=>{s.value=n,r?r(e):t(x.setPageSize,{size:n}),window.scrollTo({top:0,left:0,behavior:"smooth"})}}}export{he as _,me as u};
