<?php


/*
 * Guild
 * Guild Rendering for Dofus 1.29 using Ankama Renderer
 * Script for learning purpose
 */
class Guild{
	private $GuildId;
	private $OutputFormat;
	private $EmblemForegroundShape;
	private $EmblemBackgroundShape;
	private $EmblemForegroundColor;
	private $EmblemBackgroundColor;
	private $EmblemOutputPath = "testxd/";
	
	public function __construct($guildId, $emblemForegroundShape, $emblemBackgroundShape, $emblemForegroundColor, $emblemBackgroundColor, $format = 'png')
	{
		$this->EmblemForegroundShape = $emblemForegroundShape;
		$this->EmblemBackgroundShape = $emblemBackgroundShape;
		$this->EmblemForegroundColor = $emblemForegroundColor;
		$this->EmblemBackgroundColor = $emblemBackgroundColor;
		$this->OutputFormat = $format;
		$this->GuildId = $guildId;
	}

	private function getEmblemForegroundColor()
	{
		return base_convert($this->EmblemForegroundColor, 36, 10);
	}

	private function getEmblemForegroundShape()
	{
		return base_convert($this->EmblemForegroundShape, 36, 10);
	}

	private function getEmblemBackgroundColor()
	{
		return base_convert($this->EmblemBackgroundColor, 36, 10);
	}

	private function getEmblemBackgroundShape()
	{
		return base_convert($this->EmblemBackgroundShape , 36, 10);
	}

	public function render()
	{
		$guildId = $this->GuildId;
		$EmblemForegroundShape = $this->getEmblemForegroundShape();
		$EmblemBackgroundShape = $this->getEmblemBackgroundShape();
		$EmblemForegroundColor = $this->getEmblemForegroundColor();
		$EmblemBackgroundColor = $this->getEmblemBackgroundColor();
		$format = $this->OutputFormat;
		$data = @file_get_contents($this->EmblemOutputPath."$guildId.$format");
		if ($data)
		{
			return $this->EmblemOutputPath."$guildId.$format"; //Vous devez retourner un lien vers le visuel de l'embleme pour le test j'ai laissé ça. Modifiez ça 
		}
		else
		{
			$url = "http://staticns.ankama.com/dofus/renderer/emblem/$EmblemForegroundShape/$EmblemBackgroundShape/0x" . strtoupper(dechex($EmblemForegroundColor)) . "/0x" . strtoupper(dechex($EmblemBackgroundColor)) . "/110_110-0.png";
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_COOKIESESSION, true);
			$result = curl_exec($curl);
			$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			if ($code == 404)
			{
				//Can happen faudrais mettre un truc genre une image vide ?
				return "";
			}
			else
			{
				file_put_contents($this->EmblemOutputPath."$guildId.$format", $result); //L'emblem est enregistré ici 
				return $this->EmblemOutputPath."$guildId.$format"; //Vous devez retourner un lien vers le visuel de l'embleme pour le test j'ai laissé ça. Modifiez ça 
			}

			curl_close($curl);
		}
	}
}