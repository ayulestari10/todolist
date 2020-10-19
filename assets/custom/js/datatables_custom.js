var TableDatatablesResponsive = function() {
    var t = function() {
            var e = $(".datatable_basic");
            e.dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                columnDefs: [{
                    className: "control",
                    orderable: true,
                    targets: 0
                }],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                pagingType: "bootstrap_extended"
            })
        },
        tne = function() {
            var e = $(".datatable_no_entries");
            e.dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                columnDefs: [{
                    className: "control",
                    orderable: true,
                    targets: 0
                }],
                "lengthChange": false,
                pageLength: 10,
                pagingType: "bootstrap_extended"
            })
        },
        bo = function() {
            var e = $(".datatable_basic_order_2");
            e.dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                columnDefs: [{
                    className: "control",
                    orderable: true,
                    targets: 0
                }],
                order: [
                    [1, "asc"]
                ],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                pagingType: "bootstrap_extended"
            })
        },
        o = function() {
            var e = $(".datatable_button");
            e.dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [{
                    extend: "print",
                    className: "btn default"
                }, {
                    extend: "pdf",
                    className: "btn default"
                }, {
                    extend: "csv",
                    className: "btn default"
                },{
                    extend: "excel",
                    className: "btn default"
                }],
                colReorder: {
                    reorderCallback: function() {
                        console.log("callback")
                    }
                },
                rowReorder: {},
                order: [
                    [0, "asc"]
                ],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
            })
        },
        o2 = function() {
            var e = $(".datatable_button2");
            e.dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [{
                    extend: "excel",
                    className: "btn default ",
                    exportOptions: {
                        // columns:function(idx, data, node){
                        //     if(idx == 0){return false;}
                        //     else{return true;}
                        // }
                        columns: 'th:not(:last-child)'
                    }
                }],
                colReorder: {
                    reorderCallback: function() {
                        console.log("callback")
                    }
                },
                order: [
                    [0, "asc"]
                ],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
            })
        },
        o3 = function() {
            var e = $(".datatable_button3");
            e.dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [{
                    extend: "excel",
                    className: "btn default "
                }, 
                {
                    extend: "pdf",
                    className: "btn default"
                }],
                colReorder: {
                    reorderCallback: function() {
                        console.log("callback")
                    }
                },
                order: [
                    [0, "asc"]
                ],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
            })
        },
         a = function() {
            var e = $(".datatable_pdf_excel");
            e.dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [{
                    extend: "pdf",
                    className: "btn red btn-outline",
                    exportOptions: {
                        columns:function(idx, data, node){
                            if(idx == 0){return false;}
                            else{return true;}
                        }
                    }
                }, {
                    extend: "excel",
                    className: "btn green btn-outline ",
                    exportOptions: {
                        columns:function(idx, data, node){
                            if(idx == 0){return false;}
                            else{return true;}
                        }
                    }
                }],
                responsive: !0,
                order: [
                    [0, "asc"]
                ],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
            })
        },
        s = function() {
            var e = $(".datatable_scroll");
            e.dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                scrollY: 225,
                deferRender: !0,
                 "scrollX": true,
                scroller: !0,
                stateSave: !0,
                lengthMenu: [
                    [10, 15, 20, -1],
                    [10, 15, 20, "All"]
                ],
                pageLength: -1
            })
        },
        s2 = function() {
            var e = $(".datatable_scroll_2");
            e.dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Total Entries : _TOTAL_ Data",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                columnDefs: [{
                    // className: "control",
                    // orderable: true,
                    // targets: 0
                    "type": "numeric", targets: 2
                }],
                order: [
                    [1, "asc"]
                ],
                scrollY: 225,
                "scrollX": true,
                deferRender: !0,
                scroller: !0,
                paging:true,
                
                aLengthMenu: [
                    [-1],
                    [ "All"]
                ],
                iDisplayLength: -1,
                pageLength: -1
            });   
        },
        o4 = function() {
            var e = $(".datatable_button4");
            e.dataTable({
                language: {
                    aria: {
                        sortAscending: ": activate to sort column ascending",
                        sortDescending: ": activate to sort column descending"
                    },
                    emptyTable: "No data available in table",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries found",
                    infoFiltered: "(filtered1 from _MAX_ total entries)",
                    lengthMenu: "_MENU_ entries",
                    search: "Search:",
                    zeroRecords: "No matching records found"
                },
                buttons: [{
                    extend: "excel",
                    className: "btn default ",
                    exportOptions: {
                        // columns:function(idx, data, node){
                        //     if(idx == 0){return false;}
                        //     else{return true;}
                        // }
                        // columns: 'th:not(:last-child)'
                    }
                }],
                colReorder: {
                    reorderCallback: function() {
                        console.log("callback")
                    }
                },
                order: [
                    [0, "asc"]
                ],
                lengthMenu: [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "All"]
                ],
                pageLength: 10,
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
            })
        }
        ;
    return {
        init: function() {
            jQuery().dataTable && (t(),o(),o2(),o3(),o4(),a(),s(),bo(),s2(),tne())
        }
    }
}();
jQuery(document).ready(function() {
    // TableDatatablesResponsive.init()
});