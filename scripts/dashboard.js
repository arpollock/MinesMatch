var curr_tab = 'pending';

// $(document).ready( function() {
//     $("#new_user").hide();
// });

function toggle_match_tab(new_tab) {
    curr_tab = new_tab;
    if( curr_tab === 'pending') {
        $("#pending-matches").show();
        $("#successful-matches").hide();
        $("#pending-matches-tab").addClass("tab-item-active");
        $("#successful-matches-tab").removeClass("tab-item-active");
    } else if( curr_tab === 'successful' ) {
        $("#pending-matches").hide();
        $("#successful-matches").show();
        $("#pending-matches-tab").removeClass("tab-item-active");
        $("#successful-matches-tab").addClass("tab-item-active");
    } // else like wtf is this
    
}