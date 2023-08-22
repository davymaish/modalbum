
    import moment from "moment";
    window.moment = moment;

    import WebTorrent from 'webtorrent/dist/webtorrent.min.js'

    const client = new WebTorrent()

    function WebTorrentInit(torrentId) {

        navigator.serviceWorker.register('/sw.min.js', { scope: '/' }).then(reg => {
            const worker = reg.active || reg.waiting || reg.installing
            function checkState (worker) {
                return worker.state === 'activated' && client.createServer({ controller: reg }) && download(torrentId)
            }
            if (!checkState(worker)) {
                worker.addEventListener('statechange', ({ target }) => checkState(target))
            }
        })

        function download(torrentId) {

            // HTML elements
            let $body = document.body;
            let $progressBar = document.querySelector('#progressBar');
            let $numPeers = document.querySelector('#numPeers');
            let $downloaded = document.querySelector('#downloaded');
            let $total = document.querySelector('#total');
            let $remaining = document.querySelector('#remaining');
            let $uploadSpeed = document.querySelector('#uploadSpeed');
            let $downloadSpeed = document.querySelector('#downloadSpeed');
            let $torrentName = document.querySelector('#torrentName');

            client.add(torrentId, {maxWebConns: 10}, torrent => {

                // Torrents can contain many files. Let's use the .mp4 file
                const file = torrent.files.find(file => {
                    return file.name.endsWith('.mp4')
                })

                $torrentName.innerHTML = file.name;

                // Stream the file in the browser
                file.streamTo(document.querySelector('#output'))

                // Trigger statistics refresh
                torrent.on('done', onDone)
                setInterval(onProgress, 500)
                onProgress()

                // Statistics
                function onProgress () {
                    // Peers
                    $numPeers.innerHTML = torrent.numPeers + (torrent.numPeers === 1 ? ' peer' : ' peers')

                    // Progress
                    let percent = Math.round(torrent.progress * 100 * 100) / 100
                    $progressBar.style.width = percent + '%'
                    $downloaded.innerHTML = prettyBytes(torrent.downloaded)
                    $total.innerHTML = prettyBytes(torrent.length)

                    // Remaining time
                    let remaining
                    if (torrent.done) {
                      remaining = 'Done.'
                    } else {
                      remaining = moment.duration(torrent.timeRemaining / 1000, 'seconds').humanize()
                      remaining = remaining[0].toUpperCase() + remaining.substring(1) + ' remaining.'
                    }
                    $remaining.innerHTML = remaining

                    // Speed rates
                    $downloadSpeed.innerHTML = prettyBytes(torrent.downloadSpeed) + '/s'
                    $uploadSpeed.innerHTML = prettyBytes(torrent.uploadSpeed) + '/s'
                }

                function onDone () {
                    $body.className += ' is-seed'
                    onProgress()
                }
            })
        }
    }

    // Human readable bytes util
    function prettyBytes (num) {
        const units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
        const neg = num < 0
        if (neg) num = -num
        if (num < 1) return (neg ? '-' : '') + num + ' B'
        const exponent = Math.min(Math.floor(Math.log(num) / Math.log(1000)), units.length - 1)
        const unit = units[exponent]
        num = Number((num / Math.pow(1000, exponent)).toFixed(2))
        return (neg ? '-' : '') + num + ' ' + unit
    }

    window.WebTorrentInit = WebTorrentInit;