/**
 * @class Bds.module.d_sekolah_sltp
 * Module panel for table bds_d_sekolah_sltp
 *
 * @since 23-10-2012 12:07:20
 * @author wiliamdecosta@gmail.com
 */
Bds.module.d_sekolah_sltp = Ext.extend(Webi.module.Panel, {
    addTitle: 'Tambah SLTP',
    editTitle: 'Edit SLTP',
    winWidth:597,
    winHeight:520,
    levelSekolah: 'SLTP',
    /**
     * initComponent
     * @protected
     */
    initComponent : function() {
        // super
        Bds.module.d_sekolah_sltp.superclass.initComponent.call(this);
    },
    buildPanel : function(){
        this.grid = new Bds.grid.d_sekolah({border: false, levelSekolah:this.levelSekolah});
        this.initGridEvents();

        /* set masterId name for master-detail grid handling */
		this.masterId = 'd_sekolah_id';
		this.displayId = 'sekolah_name';
		
		this.details = {
			t_siswa : new Bds.module.t_siswa({disabled: true, formTitle:'Siswa'})
		};
		
		this.details.t_siswa.grid.store.on('beforeload', this.onBeforeLoadDetail, this);
		
		this.tabPanel = new Ext.TabPanel({
		    enableTabScroll:true,
		    defaults: {autoScroll:true},
		    activeTab: 't_siswa',
		    border: false,
		    items: [
				{itemId: 't_siswa', title: 'Siswa', layout: 'fit', items: this.details.t_siswa}
			]
		});
		this.tabPanel.on('tabchange', function(tabpanel, tab){
		    var sm = this.grid.getSelectionModel();
		    var rec = sm.getSelected();
		
		    if (rec) this.onRowSelectMasterGrid(sm, null, rec);
		}, this);
		
		this.grid.getSelectionModel().on('rowselect', this.onRowSelectMasterGrid, this);

        /* return configured layout */
		return {
		    xtype: 'panel',
		    layout: 'border',
		    border: false,
		    items : [
		        {
		            region: 'center',
		            margins: '1 1 0 1',
		            layout: 'fit',
		            minHeight: 110,
		            items: this.grid
		        },
		        {
		            region: 'south',
		            margins: '0 1 1 1',
		            cmargins: '1 1 1 1',
		            height: 200,
		            minHeight: 110,
		            split: true,
		            collapsible: true,
		            collapseMode: 'mini',
		            hideCollapseTool: true,
		            layout: 'fit',
		            items: this.tabPanel
		        }
		    ]
		};
    },
    buildForm : function(){
        this.form = new Bds.form.d_sekolah({levelSekolah:this.levelSekolah});
		this.initFormEvents();
		
		
		return this.form;
    }
});

Ext.reg('module_d_sekolah_sltp', Bds.module.d_sekolah_sltp);