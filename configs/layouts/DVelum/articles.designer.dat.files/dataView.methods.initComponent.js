this.tpl = new Ext.XTemplate(
  '<tpl for=".">',
  	'<div class="dv_article-wrap">',
            '<tpl if="image.length">',
                 '<div class="pic"><img src="{image}"></div><div class="clear"></div>',
            '</tpl>',
  			'<div class="content">',
  				'<tpl if="published">',
                    '<div class="headTools">',
                        '<span class="label">'+appLang.VERSIONS_HEADER+': </span>',
                        '<tpl if="published_version === last_version">',
                            '<span class="versions green">{published_version} / {last_version}</span>',
                        '<tpl else>',
                            '<span class="versions yellow">{published_version} / {last_version}</span>',
                         '</tpl>',
                    '</div>',
                 '</tpl>',
                  '<div class="title">{title}</div>',
                  '<div class="brief">{brief}</div>',
  			'</div>',
      		'<div class="updateInfo">',
              '<tpl if="published">',
              		'<span class="publishDate" data-qtip="'+appLang.DATE_PUBLISHED+'">{date_published:this.formatDate}</span>,',
              '<tpl else>',
              		'<span class="version">' + appLang.VERSION + ': {last_version}</span> ',
              		'<span class="publishDate" data-qtip="'+appLang.DATE_UPDATED+'">{date_updated:this.formatDate}</span>, ',
              '</tpl>',
              		'<span class="author" data-qtip="'+appLang.AUTHOR+'">{user}</span>',
            '</div>',
    		'<div class="bottomTools bottomTools_{id}">',
   			'</div>',
  	'</div>',
  '</tpl>',
  {
  	 formatDate: function(val){
     	return Ext.Date.format(val, 'H:i d.m.Y ');
     }
  }
);
this.callParent();
this.on('refresh',function(){
  	var el = this.getEl();
    // create card buttons
    this.getStore().each(function(record){
      var renderTo = el.select('.bottomTools_' + record.get('id')).elements[0];
      Ext.create('Ext.toolbar.Toolbar', {
    	renderTo: renderTo,
        width:280,
        ui:'footer',
        style:'text-align:center;',
        items:[
          '->',
          {
        	  text:appLang.EDIT,
              scope:this,
              icon:'[%wroot%]i/system/edit.png',
              articleId:record.get('id'),
              handler:function(btn){
                this.fireEvent('editCall', record);
              } 
          },{
          	icon:'[%wroot%]i/system/html.png',
             text:appLang.PREVIEW,
             hrefTarget:'_blank',
             style:{
               marginLeft:'5px'
             },
             href:record.get('staging_url') + '?vers=' + record.get('last_version')
          }
        ]
      });
      
  },this);
},this);