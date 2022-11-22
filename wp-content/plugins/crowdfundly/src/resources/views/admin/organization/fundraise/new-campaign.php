<div id="fundraise">
    <layout-campaign variant="fundraise">
        <div class="new-campaign_wrapper">
            <fundraise-type v-if="!campaignWizard.active"></fundraise-type>

            <div v-if="campaignWizard.active === $campaignTypes.DONATION">
                <donation-basic></donation-basic>
            </div>

            <div v-if="campaignWizard.active === $campaignTypes.SPONSOR">
                <sponsor-basic v-if="isActive('basic')"></sponsor-basic>

                <sponsor-package v-if="isActive('package')"></sponsor-package>
            </div>

            <div v-if="campaignWizard.active === $campaignTypes.FUNDRAISE">
                <fundraising-basic v-if="isActive('basic')" v-model="basicData"></fundraising-basic>

                <fundraising-media v-if="isActive('media')"></fundraising-media>

                <fundraising-story v-if="isActive('story')"></fundraising-story>

                <fundraising-additional-info v-if="isActive('additional_info')"></fundraising-additional-info>

                <fundraising-reward v-if="isActive('reward')"></fundraising-reward>
            </div>
        </div>
    </layout-campaign>
</div>

<script>
    const app = new Vue({
        el: '#fundraise',
        data() {
            return {
                basicData: null,
                mediaData: null,
                story: null,
                additionalInfo: null,
                rewardData: null,
            };
        },
        computed: this.$mapState({
            campaignWizard: state => state.campaignWizard
        }),
        created() {
            let current = {
                "id": 740,
                "type": 3,
                "name": "Test Campaign123",
                "slug": "test-campaign123-78609",
                "target_amount": 3333,
                "target_date": null,
                "offline_raised_amount": 0,
                "raised_amount": 0,
                "currency_id": 19,
                "currency_code": "BAM",
                "currency_symbol": "KM",
                "status": 0,
                "target_amount_raised": null,
                "organization_id": 150,
                "created_at": "2022-01-25T10:36:32.000000Z",
                "updated_at": "2022-01-25T10:36:32.000000Z",
                "creator": {
                    "id": 232,
                    "name": "",
                    "country": null,
                    "avatar": "https://api.crowdfundly.app/images/avatar.png",
                    "uuid": "ee1e9287-d577-4e5d-a3c5-0ee73e9ae7be",
                    "username": "-79505",
                    "donation_amount": "0.00",
                    "share_count": 0,
                    "campaign_count": 0,
                    "bio": null,
                    "created_at": "2021-05-02T05:52:38.000000Z"
                },
                "organization": {
                    "id": 150,
                    "name": "Italiano",
                    "username": "italiano",
                    "address": "Dhaka, Bangladesh.",
                    "description": "<p><span style=\"color: rgb(60, 64, 67);\">RFL started its journey with cast iron (CI) products in 1980. The initial main objective was to ensure pure water and affordable irrigation instruments for improving rural life. Today the company has its wide ranges of CI products like pumps, tube wells, bearings, gas stoves, etc and has achieved prestige as the largest cast iron foundry and light engineering workshop in Bangladesh.&nbsp;</span></p>",
                    "contact_number": "4444444",
                    "contact_number_code": {
                        "id": 240,
                        "country_name": "United States",
                        "capital": "Washington DC",
                        "citizenship": "American",
                        "currency": "US dollar",
                        "currency_code": "USD",
                        "full_name": "United States of America",
                        "short_name": "US",
                        "country_mobile_code": "1",
                        "currency_symbol": "$",
                        "flag": "US.png"
                    },
                    "creator_id": 231,
                    "country_id": 240,
                    "template_id": 2,
                    "gallery": [
                        {
                            "id": 1188,
                            "source_type": "App\\Models\\Organization",
                            "source_id": 150,
                            "source": "organization_gallery/231_organization_gallery_20210614092441_ex_275.jpg",
                            "source_path": "https://dev-crowdfundly-bucket.s3.ap-south-1.amazonaws.com/organization_gallery/231_organization_gallery_20210614092441_ex_275.jpg",
                            "priority": 0,
                            "created_at": "2021-06-14T09:24:42.000000Z",
                            "updated_at": "2021-06-14T09:24:42.000000Z",
                            "media_type": 3,
                            "deleted_at": null
                        },
                        {
                            "id": 1189,
                            "source_type": "App\\Models\\Organization",
                            "source_id": 150,
                            "source": "organization_gallery/231_organization_gallery_20210614092459_ex_745.png",
                            "source_path": "https://dev-crowdfundly-bucket.s3.ap-south-1.amazonaws.com/organization_gallery/231_organization_gallery_20210614092459_ex_745.png",
                            "priority": 0,
                            "created_at": "2021-06-14T09:25:00.000000Z",
                            "updated_at": "2021-06-14T09:25:00.000000Z",
                            "media_type": 3,
                            "deleted_at": null
                        },
                        {
                            "id": 1276,
                            "source_type": "App\\Models\\Organization",
                            "source_id": 150,
                            "source": "organization_gallery/231_organization_gallery_20211004045553_ex_642.png",
                            "source_path": "https://storage.googleapis.com/cfd_prod_bucket_001/organization_gallery/231_organization_gallery_20211004045553_ex_642.png",
                            "priority": 0,
                            "created_at": "2021-10-04T04:55:54.000000Z",
                            "updated_at": "2021-10-04T04:55:54.000000Z",
                            "media_type": 3,
                            "deleted_at": null
                        },
                        {
                            "id": 1311,
                            "source_type": "App\\Models\\Organization",
                            "source_id": 150,
                            "source": "organization_gallery/231_organization_gallery_20211029173242_ex_177.jpg",
                            "source_path": "https://storage.googleapis.com/cfd_prod_bucket_001/organization_gallery/231_organization_gallery_20211029173242_ex_177.jpg",
                            "priority": 0,
                            "created_at": "2021-10-29T17:32:44.000000Z",
                            "updated_at": "2021-10-29T17:32:44.000000Z",
                            "media_type": 3,
                            "deleted_at": null
                        },
                        {
                            "id": 1346,
                            "source_type": "App\\Models\\Organization",
                            "source_id": 150,
                            "source": "organization_gallery/231_organization_gallery_20211113163244_ex_323.jpg",
                            "source_path": "https://storage.googleapis.com/cfd_prod_bucket_001/organization_gallery/231_organization_gallery_20211113163244_ex_323.jpg",
                            "priority": 0,
                            "created_at": "2021-11-13T16:32:46.000000Z",
                            "updated_at": "2021-11-13T16:32:46.000000Z",
                            "media_type": 3,
                            "deleted_at": null
                        },
                        {
                            "id": 1453,
                            "source_type": "App\\Models\\Organization",
                            "source_id": 150,
                            "source": "organization_gallery/231_organization_gallery_20211223104517_ex_307.jpg",
                            "source_path": "https://storage.googleapis.com/cfd_prod_bucket_001/organization_gallery/231_organization_gallery_20211223104517_ex_307.jpg",
                            "priority": 0,
                            "created_at": "2021-12-23T10:45:18.000000Z",
                            "updated_at": "2021-12-23T10:45:18.000000Z",
                            "media_type": 3,
                            "deleted_at": null
                        }
                    ],
                    "logo": {
                        "id": 1350,
                        "source_type": "App\\Models\\Organization",
                        "source_id": 150,
                        "source": "organization_logo/231_organization_logo_20211118115129_ex_727.png",
                        "source_path": "https://storage.googleapis.com/cfd_prod_bucket_001/organization_logo/231_organization_logo_20211118115129_ex_727.png",
                        "priority": 0,
                        "created_at": "2021-11-18T11:51:30.000000Z",
                        "updated_at": "2021-11-18T11:51:30.000000Z",
                        "media_type": 8,
                        "deleted_at": null
                    },
                    "cover_photo": {
                        "id": 1312,
                        "source_type": "App\\Models\\Organization",
                        "source_id": 150,
                        "source": "organization_cover_photo/231_organization_cover_photo_20211029173312_ex_997.jpg",
                        "source_path": "https://storage.googleapis.com/cfd_prod_bucket_001/organization_cover_photo/231_organization_cover_photo_20211029173312_ex_997.jpg",
                        "priority": 0,
                        "created_at": "2021-10-29T17:33:13.000000Z",
                        "updated_at": "2021-10-29T17:33:13.000000Z",
                        "media_type": 4,
                        "deleted_at": null
                    },
                    "favicon": {
                        "id": 1351,
                        "source_type": "App\\Models\\Organization",
                        "source_id": 150,
                        "source": "organization_favicon/231_organization_favicon_20211118115204_ex_272.png",
                        "source_path": "https://storage.googleapis.com/cfd_prod_bucket_001/organization_favicon/231_organization_favicon_20211118115204_ex_272.png",
                        "priority": 0,
                        "created_at": "2021-11-18T11:52:05.000000Z",
                        "updated_at": "2021-11-18T11:52:05.000000Z",
                        "media_type": 9,
                        "deleted_at": null
                    },
                    "socialProfiles": [
                        {
                            "id": 746,
                            "resource_type": "App\\Models\\Organization",
                            "resource_id": 150,
                            "social_network_id": 1,
                            "link": "https://www.facebook.com/",
                            "created_at": "2021-05-02T05:52:37.000000Z",
                            "updated_at": "2021-05-02T05:52:37.000000Z",
                            "deleted_at": null
                        },
                        {
                            "id": 747,
                            "resource_type": "App\\Models\\Organization",
                            "resource_id": 150,
                            "social_network_id": 2,
                            "link": "https://www.twitter.com/",
                            "created_at": "2021-05-02T05:52:37.000000Z",
                            "updated_at": "2021-05-05T05:07:01.000000Z",
                            "deleted_at": null
                        },
                        {
                            "id": 748,
                            "resource_type": "App\\Models\\Organization",
                            "resource_id": 150,
                            "social_network_id": 3,
                            "link": "https://www.linkedin.com/",
                            "created_at": "2021-05-02T05:52:37.000000Z",
                            "updated_at": "2021-05-05T05:07:01.000000Z",
                            "deleted_at": null
                        },
                        {
                            "id": 749,
                            "resource_type": "App\\Models\\Organization",
                            "resource_id": 150,
                            "social_network_id": 4,
                            "link": null,
                            "created_at": "2021-05-02T05:52:37.000000Z",
                            "updated_at": "2021-05-05T05:07:01.000000Z",
                            "deleted_at": null
                        },
                        {
                            "id": 750,
                            "resource_type": "App\\Models\\Organization",
                            "resource_id": 150,
                            "social_network_id": 5,
                            "link": "https://www.youtube.com/",
                            "created_at": "2021-05-02T05:52:37.000000Z",
                            "updated_at": "2021-05-05T05:06:39.000000Z",
                            "deleted_at": null
                        }
                    ],
                    "allow_public_fundraise": true,
                    "allow_public_login": true,
                    "currency_format": true,
                    "language_setting": true,
                    "permissions": [
                        "create_role",
                        "update_role",
                        "assign_member",
                        "update_member",
                        "delete_member",
                        "create_campaign",
                        "update_campaign",
                        "delete_campaign",
                        "update_organization",
                        "view_donation",
                        "view_refund",
                        "create_category"
                    ],
                    "plan_permission": [],
                    "currency_code": "USD",
                    "currency_id": 212,
                    "currency": {
                        "id": 212,
                        "name": "United States",
                        "icon": null,
                        "currency_code": "USD",
                        "symbol": "$",
                        "is_base_currency": 0,
                        "status": 1,
                        "created_at": "2021-01-28T08:39:17.000000Z",
                        "updated_at": "2021-01-28T08:39:17.000000Z",
                        "supported_gateways": [
                            "stripe_connect",
                            "stripe",
                            "paypal"
                        ]
                    },
                    "currency_symbol": "$",
                    "default_stripe": null,
                    "active_campaigns_count": 68,
                    "gateways": [
                        "paypal",
                        "stripe"
                    ],
                    "auth_org_role": "owner",
                    "is_active": true,
                    "fundraiser_settings": {
                        "allow_custom_payment": true,
                        "auto_approval": false,
                        "update_auto_approval": false,
                        "escrow_duration": 1440,
                        "escrow_enabled": false,
                        "allow_refund": true,
                        "allow_public_fundraise": true,
                        "show_similar_campaigns": false
                    },
                    "donation_settings": {
                        "wants_tip": false,
                        "tip_percentage": 5,
                        "commission_percentage": null
                    },
                    "custom_domain": "",
                    "fundraiser_custom_payment": true,
                    "brand_color": {
                        "primary": "#673AB7",
                        "secondary": "#FF9800"
                    }
                },
                "packages": [],
                "rewards": [
                    {
                        "id": 186,
                        "campaign_id": 740,
                        "title": "Test",
                        "regular_price": "10",
                        "offer_price": "5",
                        "description": "nggngngn",
                        "is_shipping": true,
                        "image": {
                            "id": 2254,
                            "url": "https:\/\/storage.googleapis.com\/cfd_prod_bucket_001\/organization\/232_organization_20220126064926_ex_937.png"
                        },
                        "stock": "1",
                        "shipping_info": [{"location": "Afghanistan", "shippingFee": "10"}, {
                            "location": "Algeria",
                            "shippingFee": "2"
                        }],
                        "created_at": "2022-01-26T06:49:28.000000Z",
                        "updated_at": "2022-01-26T06:49:28.000000Z",
                        "dynamic_form": {
                            "title": "Additional Information",
                            "consent": {"enable": false, "text": "I agree to the terms and conditions"},
                            "fields": [{
                                "type": "text",
                                "label": "555555555555",
                                "placeholder": "5555555555555",
                                "is_required": true
                            }]
                        }
                    }
                ],
                "thumbnail": null,
                "auth_member_of_org": true,
                "organization_stripe_id": null,
                "options": {
                    "gallery": {
                        "thumbnail": {},
                        "media": []
                    },
                    "presets": [],
                    "story": "",
                    "flyer": "",
                    "dynamic_form": {},
                    "recurring": false,
                    "gateways": []
                }
            }
            // this.$store.commit('campaign/add', current)
            // this.$store.commit('campaign/setCurrent', current)
        },
        methods: {
            isActive(page) {
                return this.campaignWizard.menu[this.campaignWizard.active][page].active && !this.campaignWizard.menu[this.campaignWizard.active][page].completed;
            }
        },
    });
</script>

