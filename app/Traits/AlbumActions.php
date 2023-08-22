<?php

namespace App\Traits;

use Request;
use App\Models\Album;
use App\Jobs\DeleteImage;
use Auth;
use Str;

trait AlbumActions
{
    /**
     * Hook into the Eloquent model events to create or update the slug as required.
     *
     * @return void
     */
    public static function bootAlbumActions()
    {
        //actions here
    }

    /**
     * Set the slug attribute.
     *
     * @param string $value
     * @return void
     */
    public function createNewAlbum($data)
    {
        $hash = $this->generateHash();
        $expire = ($data['expire'] >= 43800) ? 43800 : $data['expire'];

        while (Album::where('hash', $hash)->first()) {
            $hash = $this->generateHash();
        }

        $new_data = [
            'hash'              => $hash,
            'title'             => !empty($data['title']) ? $data['title'] : null,
            'description'       => !empty($data['description']) ? $data['description'] : null,
            'adult'             => !empty($data['adult']) ? 1 : 0,
            'private'           => !empty($data['private']) ? 1 : 0,
            'expire'            => !empty($expire) ? carbon()->addMinutes($expire) : null,
            'created_by'        => (Auth::check()) ? Auth::id() : 1,
        ];
        
        $album = Album::create($new_data);

        /*$album = new Album();
        $album->fill($new_data);
        $album->save();*/

        return $album;
    }

    /**
     * Set the slug attribute.
     *
     * @param string $value
     * @return void
     */
    public function deleteAlbum($album)
    {
        if ($album->created_by == Auth::id() || Auth::id() == 2) {

            //delete images
            if (!empty($album->images)) {
                foreach ($album->images as $image) {
                    $this->dispatch(new DeleteImage($image->id));
                }
            }

            $album->delete();

            return [
                'success' => true,
                'message' => 'Album Deleted Successfully!'
            ];
        }

        else {
            return [
                'success' => false,
                'message' => 'System Error!'
            ];
        }
    }

    public function generateHash($length = 6)
    {
        $hash = Str::random($length);
        while (in_array(strtolower($hash), $this->excluded_words())) {
            $hash = Str::random($length);
        }

        return $hash;
    }

    /**
     * @return array
     */
    public function excluded_words()
    {
        return [
        'abroad', 'accept', 'access', 'across', 'acting', 'action', 'active', 'actual', 'advice', 'advise', 'affect', 'afford', 'afraid', 'agency', 'agenda', 'almost', 'always', 'amount', 'animal', 'annual', 'answer', 'anyone', 'anyway', 'appeal', 'appear', 'around', 'arrive', 'artist', 'aspect', 'assess', 'assist', 'assume', 'attack', 'attend', 'august', 'author', 'avenue', 'backed', 'barely', 'battle', 'beauty', 'became', 'become', 'before', 'behalf', 'behind', 'belief', 'belong', 'berlin', 'better', 'beyond', 'bishop', 'border', 'bottle', 'bottom', 'bought', 'branch', 'breath', 'bridge', 'bright', 'broken', 'budget', 'burden', 'bureau', 'button', 'camera', 'cancer', 'cannot', 'carbon', 'career', 'castle', 'casual', 'caught', 'center', 'centre', 'chance', 'change', 'charge', 'choice', 'choose', 'chosen', 'church', 'circle', 'client', 'closed', 'closer', 'coffee', 'column', 'combat', 'coming', 'common', 'comply', 'copper', 'corner', 'costly', 'county', 'couple', 'course', 'covers', 'create', 'credit', 'crisis', 'custom', 'damage', 'danger', 'dealer', 'debate', 'decade', 'decide', 'defeat', 'defend', 'define', 'degree', 'demand', 'depend', 'deputy', 'desert', 'design', 'desire', 'detail', 'detect', 'device', 'differ', 'dinner', 'direct', 'doctor', 'dollar', 'domain', 'double', 'driven', 'driver', 'during', 'easily', 'eating', 'editor', 'effect', 'effort', 'eighth', 'either', 'eleven', 'emerge', 'empire', 'employ', 'enable', 'ending', 'energy', 'engage', 'engine', 'enough', 'ensure', 'entire', 'entity', 'equity', 'escape', 'estate', 'ethnic', 'exceed', 'except', 'excess', 'expand', 'expect', 'expert', 'export', 'extend', 'extent', 'fabric', 'facing', 'factor', 'failed', 'fairly', 'fallen', 'family', 'famous', 'father', 'fellow', 'female', 'figure', 'filing', 'finger', 'finish', 'fiscal', 'flight', 'flying', 'follow', 'forced', 'forest', 'forget', 'formal', 'format', 'former', 'foster', 'fought', 'fourth', 'French', 'friend', 'future', 'garden', 'gather', 'gender', 'german', 'global', 'golden', 'ground', 'growth', 'guilty', 'handed', 'handle', 'happen', 'hardly', 'headed', 'health', 'height', 'hidden', 'holder', 'honest', 'impact', 'import', 'income', 'indeed', 'injury', 'inside', 'intend', 'intent', 'invest', 'island', 'itself', 'jersey', 'joseph', 'junior', 'killed', 'labour', 'latest', 'latter', 'launch', 'lawyer', 'leader', 'league', 'leaves', 'legacy', 'length', 'lesson', 'letter', 'lights', 'likely', 'linked', 'liquid', 'listen', 'little', 'living', 'losing', 'lucent', 'luxury', 'mainly', 'making', 'manage', 'manner', 'manual', 'margin', 'marine', 'marked', 'market', 'martin', 'master', 'matter', 'mature', 'medium', 'member', 'memory', 'mental', 'merely', 'merger', 'method', 'middle', 'miller', 'mining', 'minute', 'mirror', 'mobile', 'modern', 'modest', 'module', 'moment', 'morris', 'mostly', 'mother', 'motion', 'moving', 'murder', 'museum', 'mutual', 'myself', 'narrow', 'nation', 'native', 'nature', 'nearby', 'nearly', 'nights', 'nobody', 'normal', 'notice', 'notion', 'number', 'object', 'obtain', 'office', 'offset', 'online', 'option', 'orange', 'origin', 'output', 'oxford', 'packed', 'palace', 'parent', 'partly', 'patent', 'people', 'period', 'permit', 'person', 'phrase', 'picked', 'planet', 'player', 'please', 'plenty', 'pocket', 'police', 'policy', 'prefer', 'pretty', 'prince', 'prison', 'profit', 'proper', 'proven', 'public', 'pursue', 'raised', 'random', 'rarely', 'rather', 'rating', 'reader', 'really', 'reason', 'recall', 'recent', 'record', 'reduce', 'reform', 'regard', 'regime', 'region', 'relate', 'relief', 'remain', 'remote', 'remove', 'repair', 'repeat', 'replay', 'report', 'rescue', 'resort', 'result', 'retail', 'retain', 'return', 'reveal', 'review', 'reward', 'riding', 'rising', 'robust', 'ruling', 'safety', 'salary', 'sample', 'saving', 'saying', 'scheme', 'school', 'screen', 'search', 'season', 'second', 'secret', 'sector', 'secure', 'seeing', 'select', 'seller', 'senior', 'series', 'server', 'settle', 'severe', 'sexual', 'should', 'signal', 'signed', 'silent', 'silver', 'simple', 'simply', 'single', 'sister', 'slight', 'smooth', 'social', 'solely', 'sought', 'source', 'soviet', 'speech', 'spirit', 'spoken', 'spread', 'spring', 'square', 'stable', 'status', 'steady', 'stolen', 'strain', 'stream', 'street', 'stress', 'strict', 'strike', 'string', 'strong', 'struck', 'studio', 'submit', 'sudden', 'suffer', 'summer', 'summit', 'supply', 'surely', 'survey', 'switch', 'symbol', 'system', 'taking', 'talent', 'target', 'taught', 'tenant', 'tender', 'tennis', 'thanks', 'theory', 'thirty', 'though', 'threat', 'thrown', 'ticket', 'timely', 'timing', 'tissue', 'toward', 'travel', 'treaty', 'trying', 'twelve', 'twenty', 'unable', 'unique', 'united', 'unless', 'unlike', 'update', 'useful', 'valley', 'varied', 'vendor', 'versus', 'victim', 'vision', 'visual', 'volume', 'walker', 'wealth', 'weekly', 'weight', 'wholly', 'window', 'winner', 'winter', 'within', 'wonder', 'worker', 'wright', 'writer', 'yellow',
        ];
    }
}
