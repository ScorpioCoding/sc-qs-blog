function openNav(){document.getElementById("mySideNav").style.width="250px"}function closeNav(){document.getElementById("mySideNav").style.width="0"}function openPage(e,t,n){var l,o,a;for(o=document.getElementsByClassName("tabcontent"),l=0;l<o.length;l++)o[l].style.display="none";for(a=document.getElementsByClassName("tablink"),l=0;l<a.length;l++)a[l].style.backgroundColor="";document.getElementById(e).style.display="flex",t.style.backgroundColor=n}document.getElementById("defaultOpen").click();let simplemde=new SimpleMDE({element:document.getElementById("content")});function createSlug(){let e=string_to_slug(document.getElementById("title").value);document.getElementById("slug").value=e}function string_to_slug(e){e=(e=e.replace(/^\s+|\s+$/g,"")).toLowerCase();for(var t="åàáãäâèéëêìíïîòóöôùúüûñç·/_,:;",n=0,l=t.length;n<l;n++)e=e.replace(new RegExp(t.charAt(n),"g"),"aaaaaaeeeeiiiioooouuuunc------".charAt(n));return e=e.replace(/[^a-z0-9 -]/g,"").replace(/\s+/g,"-").replace(/-+/g,"-")}