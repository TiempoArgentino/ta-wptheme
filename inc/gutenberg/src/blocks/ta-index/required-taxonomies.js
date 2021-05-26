// Keep track of our locks
const locks = [];

function lock(lockIt, handle, message) {
    if (lockIt) {
        if (!locks[handle]) {
            locks[handle] = true;
            wp.data.dispatch('core/editor').lockPostSaving(handle);
            wp.data.dispatch('core/notices').createNotice(
                'error',
                message, {
                    id: handle,
                    isDismissible: false
                }
            );
        }
    } else if (locks[handle]) {
        locks[handle] = false;
        wp.data.dispatch('core/editor').unlockPostSaving(handle);
        wp.data.dispatch('core/notices').removeNotice(handle);
    }
}


/********************************************************************
 *   Determine required taxonomies
 *********************************************************************/
let requiredTaxonomies = null;
let taxonomies = null;

const requiredTaxonomiesUnsubscribe = wp.data.subscribe(() => {
    const currentPost = wp.data.select('core/editor').getCurrentPost();

    if(!currentPost || !currentPost.rb_config || !currentPost.rb_config.required_taxonomies )
        return;

    requiredTaxonomies = currentPost.rb_config.required_taxonomies;
    requiredTaxonomiesUnsubscribe();
});

/********************************************************************
 *   Lock/Unlock based on required taxonomies
 *********************************************************************/
wp.data.subscribe(() => {
    if( !requiredTaxonomies )
        return;

    for (var taxonomySlug in requiredTaxonomies) {
        if (!requiredTaxonomies.hasOwnProperty(taxonomySlug))
            continue;

        // get custom taxonomy
        const taxonomyTerms = wp.data.select('core/editor').getEditedPostAttribute(taxonomySlug);
        const taxonomy = wp.data.select('core').getTaxonomy(taxonomySlug);
        if(!taxonomy)
            continue;
        const condition = requiredTaxonomies[taxonomySlug];

        // Lock post if there are no custom taxonomy terms selected
        lock(
            condition && taxonomyTerms && !taxonomyTerms.length,
            `${taxonomySlug}-lock`,
            taxonomy.rb_config.labels.required_term_missing,
        );
    }
});
