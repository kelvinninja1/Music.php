<template>
    <!-- container-fluid is used in place of container so that the size of the
    container doesn't expand beyond the page. -->
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Actions</div>
                <div class="panel-body">
                    <a class="btn btn-primary" :href="create" v-if="checkAdmin()" target="_blank">Upload Tracks</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">Tracks</div>
                <div class="panel-body">
                    <table class="media-listing table">
                        <thead>
                            <tr class="media-row">
                                <th style="width: 5%; text-align: center;">ID</th>
                                <th style="width: 40%;">Title</th>
                                <th style="width: 30%;">Artists</th>
                                <th style="width: 20%">Albums</th>
                                <th style="width: 5%;">More</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="media-row" v-for="track in tracks">
                                <td class="id-entry">{{ track.id }}</td>
                                <td class="ellipsis">{{ track.title }}</td>
                                <td class="ellipsis" style="width: 100%;">{{ parseArtists(track.artists) }}</td>
                                <td class="ellipsis">{{ track.albums[0].name }}
                                <td>
                                    <div class="dropdown">
                                        <span class="glyphicon glyphicon-option-horizontal dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;"></span>
                                        <track-dropdown :album="track.albums[0]" :track="track"></track-dropdown>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import player from '../../player.js';

    export default {
        data: () => {
            return {
                tracks: null,
                create: document.location.origin + "/tracks/create",
                player: player
            }
        },
        methods: {
            edit: id => {
                return "/tracks/" + id + "/edit"
            },
            parseArtists: (artists) => {
                let artistString = "";
                for (let i = 0; i < artists.length; i++) {
                    artistString+=artists[i].name;
                    if (i < artists.length - 1) {
                        artistString+=", ";
                    }
                }
                return artistString;
            }
        },
        mounted() {
            $.get({
                url: document.location.origin + "/tracks",
                error: err => {
                    $('#content').html(err.responseText);
                },
                success: data => {
                    this.tracks = data;
                    this.$nextTick(() => {
                        $('.media-listing').DataTable();
                    });
                }
            });
            console.log('Component mounted.');
        }
    }
</script>
